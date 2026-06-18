<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use DataTables;

class CommentController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $comments = Comment::with('post')->select('comments.*');

            if ($request->filled('postId')) {
                $comments->where('post_id', $request->postId);
            }

            return DataTables::eloquent($comments)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="#" class="btn btn-sm btn-info" title="View" data-bs-toggle="modal" data-bs-target="#viewCommentModal" onclick="viewFullComment(\'' . $row->id . '\', \'' . addslashes($row->name) . '\', \'' . addslashes($row->comment) . '\')">
                               <i class="bi bi-eye"></i>
                            </a>
                            <button onclick="deleteComment(\'' . $row->id . '\')" class="btn btn-sm btn-danger" title="Delete">
                               <i class="bi bi-trash"></i>
                            </button>';
                    return $btn;
                })
                ->addColumn('name_formatted', function ($row) {
                    return $row->name ? ucfirst($row->name) : 'N/A';
                })
                ->addColumn('email_formatted', function ($row) {
                    return $row->email ? $row->email : 'N/A';
                })
                ->addColumn('post_title', function ($row) {
                    return $row->post ? ucfirst($row->post->title) : 'Post Deleted';
                })
                ->addColumn('comment_preview', function ($row) {
                    if (strlen($row->comment) > 100) {
                        return substr(ucfirst($row->comment), 0, 100) . '...';
                    }
                    return ucfirst($row->comment);
                })
                ->addColumn('full_comment', function ($row) {
                    return $row->comment;
                })
                ->addColumn('status_badge', function ($row) {
                    if ($row->status == 1) {
                        return '<span class="badge bg-success">Approved</span>';
                    } elseif ($row->status == 2) {
                        return '<span class="badge bg-danger">Rejected</span>';
                    } else {
                        return '<span class="badge bg-warning">Pending</span>';
                    }
                })
                ->addColumn('status_dropdown', function ($row) {
                    return '<div class="dropdown d-inline-block ms-2">
                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Change
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#" onclick="updateStatus(\'' . $row->id . '\', 0)">Pending</a></li>
                            <li><a class="dropdown-item" href="#" onclick="updateStatus(\'' . $row->id . '\', 1)">Approve</a></li>
                            <li><a class="dropdown-item" href="#" onclick="updateStatus(\'' . $row->id . '\', 2)">Reject</a></li>
                        </ul>
                    </div>';
                })
                ->addColumn('created_at_formatted', function ($row) {
                    return date('M j, Y', strtotime($row->created_at));
                })
                ->rawColumns(['action', 'status_badge', 'status_dropdown'])
                ->filterColumn('name_formatted', function ($query, $keyword) {
                    $query->where('name', 'like', '%' . $keyword . '%');
                })
                ->filterColumn('email_formatted', function ($query, $keyword) {
                    $query->where('email', 'like', '%' . $keyword . '%');
                })
                ->filterColumn('post_title', function ($query, $keyword) {
                    $query->whereHas('post', function ($q) use ($keyword) {
                        $q->where('title', 'like', '%' . $keyword . '%');
                    });
                })
                ->filterColumn('full_comment', function ($query, $keyword) {
                    $query->where('comment', 'like', '%' . $keyword . '%');
                })
                ->filterColumn('status_badge', function ($query, $keyword) {
                    if (strtolower($keyword) === 'approved' || strtolower($keyword) === 'approve' || $keyword === '1') {
                        $query->where('status', 1);
                    } elseif (strtolower($keyword) === 'rejected' || strtolower($keyword) === 'reject' || $keyword === '2') {
                        $query->where('status', 2);
                    } elseif (strtolower($keyword) === 'pending' || $keyword === '0') {
                        $query->where('status', 0);
                    }
                })
                ->orderColumn('name_formatted', function ($query, $order) {
                    $query->orderBy('name', $order);
                })
                ->orderColumn('email_formatted', function ($query, $order) {
                    $query->orderBy('email', $order);
                })
                ->orderColumn('post_title', function ($query, $order) {
                    $query->orderBy(
                        Post::select('title')
                            ->whereColumn('posts.id', 'comments.post_id'),
                        $order
                    );
                })
                ->orderColumn('status_badge', function ($query, $order) {
                    $query->orderBy('status', $order);
                })
                ->orderColumn('created_at_formatted', function ($query, $order) {
                    $query->orderBy('created_at', $order);
                })
                ->make(true);
        }

        return view('admin.comments.index');
    }

    public function updateStatus(Request $request, $id)
    {
        $comment = Comment::find($id);
        $comment->status = $request->status;
        $comment->save();
        return response(['success' => true]);
    }

    public function delete($id)
    {
        $comment = Comment::where('id', $id)->first();
        if ($comment) {
            $comment->delete();
            return response(['success' => true]);
        } else {
            return response(['success' => false]);
        }
    }
}
