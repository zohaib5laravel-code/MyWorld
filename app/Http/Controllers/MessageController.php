<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use DataTables;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $messages = ContactMessage::query();

            return DataTables::eloquent($messages)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="#" class="btn btn-sm btn-info" title="View" data-bs-toggle="modal" data-bs-target="#viewMessageModal" onclick="viewFullMessage(\'' . $row->id . '\')">
                               <i class="bi bi-eye"></i>
                            </a>
                            <button onclick="deleteMessage(\'' . $row->id . '\')" class="btn btn-sm btn-danger" title="Delete">
                               <i class="bi bi-trash"></i>
                            </button>
                            <button onclick="markAsRead(\'' . $row->id . '\')" class="btn btn-sm ' . ($row->status == 0 ? 'btn-warning' : 'btn-success') . '" title="' . ($row->status == 0 ? 'Mark as Read' : 'Mark as Unread') . '">
                               <i class="bi ' . ($row->status == 0 ? 'bi-envelope' : 'bi-envelope-open') . '"></i>
                            </button>';
                    return $btn;
                })
                ->addColumn('name_formatted', function ($row) {
                    return $row->name ? ucfirst($row->name) : 'N/A';
                })
                ->addColumn('email_formatted', function ($row) {
                    return $row->email ? $row->email : 'N/A';
                })
                ->addColumn('subject_formatted', function ($row) {
                    if (strlen($row->subject) > 50) {
                        return substr($row->subject, 0, 50) . '...';
                    }
                    return $row->subject;
                })
                ->addColumn('message_preview', function ($row) {
                    if (strlen($row->message) > 100) {
                        return substr(strip_tags($row->message), 0, 100) . '...';
                    }
                    return strip_tags($row->message);
                })
                ->addColumn('status_badge', function ($row) {
                    if ($row->status == 'read') {
                        return '<span class="badge bg-success"><i class="bi bi-envelope-open me-1"></i> Read</span>';
                    } else {
                        return '<span class="badge bg-warning"><i class="bi bi-envelope me-1"></i> Unread</span>';
                    }
                })
                ->addColumn('created_at_formatted', function ($row) {
                    return date('M j, Y h:i A', strtotime($row->created_at));
                })
                ->addColumn('updated_at_formatted', function ($row) {
                    return $row->status == 'read' ? date('M j, Y ', strtotime($row->updated_at)) : 'N/A';
                })
                ->addColumn('user_info', function ($row) {
                    $info = '';
                    if ($row->ip_address) {
                        $info .= '<small class="d-block text-muted"><i class="bi bi-globe me-1"></i> ' . $row->ip_address . '</small>';
                    }
                    if ($row->user_agent) {
                        $info .= '<small class="d-block text-muted"><i class="bi bi-laptop me-1"></i> ' . $this->parseUserAgent($row->user_agent) . '</small>';
                    }
                    return $info;
                })
                ->rawColumns(['action', 'status_badge', 'user_info'])
                ->filterColumn('name_formatted', function ($query, $keyword) {
                    $query->where('name', 'like', '%' . $keyword . '%');
                })
                ->filterColumn('email_formatted', function ($query, $keyword) {
                    $query->where('email', 'like', '%' . $keyword . '%');
                })
                ->filterColumn('subject_formatted', function ($query, $keyword) {
                    $query->where('subject', 'like', '%' . $keyword . '%');
                })
                ->filterColumn('message_preview', function ($query, $keyword) {
                    $query->where('message', 'like', '%' . $keyword . '%');
                })
                ->filterColumn('status_badge', function ($query, $keyword) {
                    if (strtolower($keyword) === 'read' || $keyword === '1') {
                        $query->where('status', 'read');
                    } elseif (strtolower($keyword) === 'unread' || $keyword === '0') {
                        $query->where('status', 'unread');
                    }
                })
                ->orderColumn('name_formatted', function ($query, $order) {
                    $query->orderBy('name', $order);
                })
                ->orderColumn('email_formatted', function ($query, $order) {
                    $query->orderBy('email', $order);
                })
                ->orderColumn('subject_formatted', function ($query, $order) {
                    $query->orderBy('subject', $order);
                })
                ->orderColumn('status_badge', function ($query, $order) {
                    $query->orderBy('status', $order);
                })
                ->orderColumn('created_at_formatted', function ($query, $order) {
                    $query->orderBy('created_at', $order);
                })
                ->make(true);
        }

        // Get statistics for the dashboard
        $totalMessages = ContactMessage::count();
        $unreadMessages = ContactMessage::where('status', 'unread')->count();
        $recentMessages = ContactMessage::latest()->limit(5)->get();

        return view('admin.messages.index', compact('totalMessages', 'unreadMessages', 'recentMessages'));
    }

    public function show($id)
    {
        $message = ContactMessage::findOrFail($id);
        
        if ($message->status == 'unread') {
            $message->status = 'read';
            $message->save();
        }
        
        return response()->json([
            'success' => true,
            'message' => $message,
            'user_agent_parsed' => $this->parseUserAgent($message->user_agent)
        ]);
    }

    public function markAsRead($id)
    {
        $message = ContactMessage::findOrFail($id);
        $message->status = $message->status == 'unread' ? 'read' : 'unread';
        $message->save();

        return response()->json([
            'success' => true,
            'status' => $message->status,
            'message' => $message->status == 'read' ? 'Message marked as read' : 'Message marked as unread'
        ]);
    }

    public function delete($id)
    {
        $message = ContactMessage::find($id);
        if ($message) {
            $message->delete();
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false], 404);
    }

    public function bulkAction(Request $request)
    {
        $action = $request->action;
        $ids = $request->ids;

        if ($action === 'mark_read') {
            ContactMessage::whereIn('id', $ids)->update(['status' => 'read']);
        } elseif ($action === 'mark_unread') {
            ContactMessage::whereIn('id', $ids)->update(['status' => 'unread']);
        } elseif ($action === 'delete') {
            ContactMessage::whereIn('id', $ids)->delete();
        }

        return response()->json(['success' => true]);
    }

    private function parseUserAgent($userAgent)
    {
        if (!$userAgent) return 'Unknown';
        
        // Simple user agent parsing
        if (strpos($userAgent, 'Mobile') !== false) {
            $device = 'Mobile';
        } elseif (strpos($userAgent, 'Tablet') !== false) {
            $device = 'Tablet';
        } else {
            $device = 'Desktop';
        }

        // Browser detection
        if (strpos($userAgent, 'Chrome') !== false) {
            $browser = 'Chrome';
        } elseif (strpos($userAgent, 'Firefox') !== false) {
            $browser = 'Firefox';
        } elseif (strpos($userAgent, 'Safari') !== false) {
            $browser = 'Safari';
        } elseif (strpos($userAgent, 'Edge') !== false) {
            $browser = 'Edge';
        } elseif (strpos($userAgent, 'Opera') !== false) {
            $browser = 'Opera';
        } else {
            $browser = 'Unknown Browser';
        }

        return $device . ' · ' . $browser;
    }
}