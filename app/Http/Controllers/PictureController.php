<?php

namespace App\Http\Controllers;

use App\Models\Picture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use DataTables;

class PictureController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $pictures = Picture::select('pictures.*');

            return DataTables::eloquent($pictures)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="' . route('pictures.edit', $row->id) . '" class="btn btn-sm btn-info" title="Edit">
                               <i class="bi bi-pencil-square"></i>
                            </a>
                            <button onclick="deletePicture(\'' . $row->id . '\')" class="btn btn-sm btn-danger" title="Delete">
                               <i class="bi bi-trash"></i>
                            </button>';
                    return $btn;
                })
                ->addColumn('type_formatted', function ($row) {
                    return $row->type ? ucfirst($row->type) : 'N/A';
                })
                ->addColumn('image_html', function ($row) {
                    return '<img src="' . asset('assets/pictures/' . $row->image) . '" loading="lazy" width="130" alt="' . $row->type . '" style="max-height: 80px; object-fit: cover;">';
                })
                ->addColumn('status_badge', function ($row) {
                    if ($row->status == 1) {
                        return '<span class="badge bg-success">Active</span>';
                    } else {
                        return '<span class="badge bg-danger">Inactive</span>';
                    }
                })
                ->addColumn('created_at_formatted', function ($row) {
                    return date('M j, Y', strtotime($row->created_at));
                })
                ->rawColumns(['action', 'image_html', 'status_badge'])
                ->filterColumn('type_formatted', function ($query, $keyword) {
                    // Make type searchable
                    $query->where('type', 'like', '%' . $keyword . '%');
                })
                ->filterColumn('status_badge', function ($query, $keyword) {
                    // Make status searchable
                    if (strtolower($keyword) === 'active' || $keyword === '1') {
                        $query->where('status', 1);
                    } elseif (strtolower($keyword) === 'inactive' || $keyword === '0') {
                        $query->where('status', 0);
                    }
                })
                ->orderColumn('type_formatted', function ($query, $order) {
                    $query->orderBy('type', $order);
                })
                ->orderColumn('status_badge', function ($query, $order) {
                    $query->orderBy('status', $order);
                })
                ->make(true);
        }

        return view('admin.pictures.index');
    }

    public function create()
    {
        return view('admin.pictures.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:gallery,banner',
            'image' => 'required|image|max:5120',
            'title' => 'nullable|max:255',
            'description' => 'nullable',
            'status' => 'boolean'
        ]);

        $img = $request->image;
        $fileName = time() . '.' . $img->getClientOriginalExtension();
        $path = public_path('assets/pictures/');
        $img->move($path, $fileName);

        $picture = new Picture();
        $picture->title = $request->title;
        $picture->type = $request->type;
        $picture->image = $fileName;
        $picture->description = $request->description;
        $picture->status = $request->status ?? 1;
        $picture->save();
        return redirect()->route('pictures.index')
            ->with('success', 'Picture added successfully');
    }

    public function show($id)
    {
        $picture = Picture::find($id);
        if ($picture) {
            return view('admin.pictures.show', compact('picture'));
        } else {
            return redirect()->route('pictures.index')
                ->with('error', 'Picture not found');
        }
    }

    public function edit($id)
    {
        $picture = Picture::find($id);
        if ($picture) {
            return view('admin.pictures.edit', compact('picture'));
        } else {
            return redirect()->route('pictures.index')
                ->with('error', 'Picture not found');
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'type' => 'required|in:gallery,banner',
            'image' => 'nullable|image|max:5120',
            'title' => 'nullable|max:255',
            'description' => 'nullable',
            'status' => 'boolean'
        ]);

        $picture = Picture::find($id);
        $fileName = $picture->image;
        if ($request->hasFile('image')) {
            $img = $request->image;
            $fileName = time() . '.' . $img->getClientOriginalExtension();
            $path = public_path('assets/pictures/');
            $img->move($path, $fileName);

            if ($picture->image && File::exists(public_path('assets/pictures/' . $picture->image))) {
                File::delete(public_path('assets/pictures/' . $picture->image));
            }
        }

        $picture->title = $request->title;
        $picture->type = $request->type;
        $picture->image = $fileName;
        $picture->description = $request->description;
        $picture->save();

        return redirect()->route('pictures.index')
            ->with('success', 'Picture updated successfully');
    }

    public function delete($id)
    {
        $picture = Picture::where('id', $id)->first();
        if ($picture) {
            if ($picture->image && File::exists(public_path('assets/pictures/' . $picture->image))) {
                File::delete(public_path('assets/pictures/' . $picture->image));
            }

            $picture->delete();
            return response(['success' => true]);
        } else {
            return response(['success' => false]);
        }
    }
}
