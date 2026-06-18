@extends('admin/app')
@section('content')

<main class="app-main">
    <!--begin::App Content Header-->
    <div class="app-content-header">
        <!--begin::Container-->
        <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">View Post</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{route('posts.index')}}">Posts</a></li>
                        <li class="breadcrumb-item active" aria-current="page">View Post</li>
                    </ol>
                </div>
            </div>
            <!--end::Row-->
        </div>
        <!--end::Container-->
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8">
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">Post Details</h5>
                            <div class="d-flex gap-2 ms-auto">
                                <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-primary btn-sm">
                                    <i class="bi bi-pencil me-1"></i> Edit Post
                                </a>
                                <a href="{{ route('posts.index') }}" class="btn btn-outline-secondary btn-sm">
                                    <i class="bi bi-arrow-left me-1"></i> Back to List
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row mb-4">
                                <div class="col-md-8">
                                    <h2 class="h4 mb-3">{{ $post->title }}</h2>
                                    <div class="d-flex align-items-center gap-3 mb-3">
                                        @php
                                        $statusColors = [
                                        'published' => 'success',
                                        'draft' => 'warning',
                                        'archived' => 'secondary'
                                        ];
                                        @endphp
                                        <span class="badge bg-{{ $statusColors[$post->status] ?? 'secondary' }}">
                                            {{ ucfirst($post->status) }}
                                        </span>
                                        <span class="text-muted">
                                            <i class="bi bi-calendar me-1"></i>
                                            {{ $post->created_at->format('M d, Y') }}
                                        </span>
                                        <span class="text-muted">
                                            <i class="bi bi-eye me-1"></i>
                                            {{ $post->views }} views
                                        </span>
                                    </div>

                                    <div class="mb-3">
                                        <strong>Category:</strong>
                                        <span class="badge bg-info">{{ $post->category->name ?? 'Uncategorized' }}</span>
                                    </div>

                                    @if($post->excerpt)
                                    <div class="mb-4">
                                        <strong>Excerpt:</strong>
                                        <p class="mb-0 text-muted">{{ $post->excerpt }}</p>
                                    </div>
                                    @endif
                                </div>

                                <div class="col-md-4">
                                    @if($post->featured_image)
                                    <div class="border rounded p-2">
                                        <div class="text-center">
                                            <img src="{{ asset('assets/posts/' . $post->featured_image) }}"
                                                alt="Featured Image"
                                                class="img-fluid rounded"
                                                style="max-height: 200px; object-fit: cover;">
                                            <div class="mt-2">
                                                <small class="text-muted">Featured Image</small>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <div class="mb-4">
                                <strong class="border-bottom pb-2">Content</strong>
                                <div class="post-content p-3 bg-light rounded">
                                    {!! $post->content !!}
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card bg-light">
                                        <div class="card-body">
                                            <h6 class="card-subtitle mb-3 text-muted">Post Information</h6>
                                            <ul class="list-unstyled mb-0">
                                                <li class="mb-2">
                                                    <i class="bi bi-person me-1 text-primary"></i>
                                                    <strong>Author:</strong> Admin
                                                </li>
                                                <li class="mb-2">
                                                    <i class="bi bi-calendar-check me-1 text-primary"></i>
                                                    <strong>Created:</strong> {{ $post->created_at->format('F d, Y h:i A') }}
                                                </li>
                                                <li class="mb-2">
                                                    <i class="bi bi-calendar-event me-1 text-primary"></i>
                                                    <strong>Updated:</strong> {{ $post->updated_at->format('F d, Y h:i A') }}
                                                </li>
                                                @if($post->published_at)
                                                <li class="mb-2">
                                                    <i class="bi bi-clock me-1 text-primary"></i>
                                                    <strong>Published:</strong>{{ date('F d, Y h:i A', strtotime($post->published_at)) }}
                                                </li>
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="card bg-light">
                                        <div class="card-body">
                                            <h6 class="card-subtitle mb-3 text-muted">Statistics</h6>
                                            <ul class="list-unstyled mb-0">
                                                <li class="mb-2">
                                                    <i class="bi bi-eye me-2 text-success"></i>
                                                    <strong>Total Views:</strong> {{ $post->views }}
                                                </li>
                                                <li class="mb-2">
                                                    <i class="bi bi-chat-left-text me-2 text-info"></i>
                                                    <strong>Comments:</strong> {{ $post->comments->count() ?? 0 }}
                                                    <a href="{{ route('comments.index') }}?postId={{ $post->id }}" class="btn btn-sm btn-outline-info ms-2">
                                                        View All
                                                    </a>
                                                </li>
                                                <li class="mb-2">
                                                    <i class="bi bi-images me-2 text-warning"></i>
                                                    <strong>Gallery Images:</strong>
                                                    @php
                                                    $galleryImages = $post->images ? json_decode($post->images, true) : [];
                                                    @endphp
                                                    {{ count($galleryImages) }}
                                                </li>
                                                <li class="mb-2">
                                                    <i class="bi bi-hash me-2 text-secondary"></i>
                                                    <strong>ID:</strong> {{ $post->id }}
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">Recent Comments</h5>
                            <a href="{{ route('comments.index') }}?postId={{ $post->id }}" class="btn btn-sm btn-outline-primary ms-auto">
                                View All Comments
                            </a>
                        </div>
                        <div class="card-body">
                            @if($recentComments && $recentComments->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Comment</th>
                                            <th>Status</th>
                                            <th>Date</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($recentComments as $comment)
                                        <tr>
                                            <td>{{ $comment->name }}</td>
                                            <td>
                                                {{ Str::limit($comment->comment, 50) }}

                                            </td>
                                            <td>
                                                @if($comment->status == 1)
                                                <span class="badge bg-success">Approved</span>
                                                @elseif($comment->status == 2)
                                                <span class="badge bg-danger">Rejected</span>
                                                @else
                                                <span class="badge bg-warning">Pending</span>
                                                @endif
                                            </td>
                                            <td>{{ $comment->created_at->format('M d, Y') }}</td>
                                            <td>
                                                <div class="btn-group btn-group-sm" role="group">
                                                    <a href="#" class="btn btn-outline-info" title="View" data-bs-toggle="modal" data-bs-target="#viewCommentModal{{ $comment->id }}">
                                                        <i class="bi bi-eye"></i>
                                                    </a>

                                                </div>
                                            </td>
                                        </tr>

                                        <div class="modal fade" id="viewCommentModal{{ $comment->id }}" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Comment by {{ $comment->name }}</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p><strong>Email:</strong> {{ $comment->email }}</p>
                                                        <p><strong>Comment:</strong></p>
                                                        <div class="p-3 bg-light rounded">
                                                            {{ $comment->comment }}
                                                        </div>
                                                        <p class="mt-3 mb-0">
                                                            <strong>Posted:</strong> {{ $comment->created_at->format('F d, Y h:i A') }}
                                                        </p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @else
                            <div class="text-center py-4">
                                <i class="bi bi-chat-left-text display-6 text-muted mb-3"></i>
                                <p class="text-muted">No comments yet for this post.</p>
                                <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-outline-primary">
                                    <i class="bi bi-pencil me-1"></i> Edit Post
                                </a>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h6 class="card-title mb-0">Post Status</h6>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                @if($post->status == 'published')
                                <div class="alert alert-success mb-0">
                                    <i class="bi bi-check-circle me-2"></i>
                                    <strong>Published</strong>
                                    @if($post->published_at)
                                    <div class="small">Published on {{ date('M d, Y', strtotime($post->published_at)) }}</div>
                                    @endif
                                </div>
                                @elseif($post->status == 'draft')
                                <div class="alert alert-warning mb-0">
                                    <i class="bi bi-pencil me-2"></i>
                                    <strong>Draft</strong>
                                    <div class="small">This post is not published yet</div>
                                </div>
                                @else
                                <div class="alert alert-secondary mb-0">
                                    <i class="bi bi-archive me-2"></i>
                                    <strong>Archived</strong>
                                    <div class="small">This post is archived</div>
                                </div>
                                @endif

                                @if($post->status != 'archived')
                                <a href="{{ route('posts.edit', $post->id) }}#status" class="btn btn-outline-primary btn-sm">
                                    <i class="bi bi-pencil me-1"></i> Change Status
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h6 class="card-title mb-0">Gallery Images</h6>
                            <span class="badge bg-secondary ms-auto">{{ count($galleryImages) }}</span>
                        </div>
                        <div class="card-body">
                            @if(count($galleryImages) > 0)
                            <div class="row g-2">
                                @foreach($galleryImages as $index => $image)
                                <div class="col-6">
                                    <div class="gallery-thumbnail position-relative">
                                        <img src="{{ asset('assets/posts/' . $image) }}"
                                            alt="Gallery Image {{ $index + 1 }}"
                                            class="img-fluid rounded border"
                                            style="height: 100px; width: 100%; object-fit: cover; cursor: pointer;"
                                            data-bs-toggle="modal"
                                            data-bs-target="#galleryModal"
                                            onclick="showGalleryImage('{{ asset('assets/posts/' . $image) }}', {{ $index + 1 }})">
                                        <div class="small text-truncate mt-1">
                                            Image {{ $index + 1 }}
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @else
                            <div class="text-center py-3">
                                <i class="bi bi-images display-6 text-muted mb-2"></i>
                                <p class="text-muted mb-0">No gallery images</p>
                            </div>
                            @endif

                            @if(count($galleryImages) > 0)
                            <div class="mt-3 text-center">
                                <a href="{{ route('posts.edit', $post->id) }}#images" class="btn btn-outline-primary btn-sm">
                                    <i class="bi bi-pencil me-1"></i> Manage Gallery
                                </a>
                            </div>
                            @endif
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header">
                            <h6 class="card-title mb-0">Quick Actions</h6>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-primary">
                                    <i class="bi bi-pencil me-2"></i> Edit Post
                                </a>
                                <button type="button" class="btn btn-outline-danger" onclick="confirmDelete()">
                                    <i class="bi bi-trash me-2"></i> Delete Post
                                </button>
                                @if($post->status == 'published')
                                <a href="{{route('frontend.post',$post->slug)}}" class="btn btn-outline-success" target="_blank">
                                    <i class="bi bi-eye me-2"></i> View Live
                                </a>
                                @endif
                                <a href="{{ route('posts.create') }}" class="btn btn-outline-secondary">
                                    <i class="bi bi-plus-circle me-2"></i> Create New Post
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h6 class="card-title mb-0">SEO & Meta Information</h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <strong class="d-block mb-1">Meta Title:</strong>
                                <span class="text-muted">{{ Str::limit($post->title, 60) }}</span>
                            </div>

                            <div class="mb-3">
                                <strong class="d-block mb-1">Meta Description:</strong>
                                <span class="text-muted">
                                    @if($post->excerpt)
                                    {{ Str::limit($post->excerpt, 160) }}
                                    @else
                                    {{ Str::limit(strip_tags($post->content), 160) }}
                                    @endif
                                </span>
                            </div>

                            <div class="mb-0">
                                <strong class="d-block mb-1">URL Slug:</strong>
                                <code class="d-block p-2 bg-light rounded">
                                    /posts/{{ $post->id }}-{{ Str::slug($post->title) }}
                                </code>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<div class="modal fade" id="galleryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Gallery Image <span id="galleryImageNumber"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <img id="galleryModalImage" src="" class="img-fluid rounded" style="max-height: 500px;">
            </div>
            <div class="modal-footer justify-content-between">
                <div>
                    <span id="galleryImageName" class="text-muted"></span>
                </div>
                <div>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <a href="{{ route('posts.edit', $post->id) }}#images" class="btn btn-primary">
                        <i class="bi bi-pencil me-1"></i> Edit Gallery
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this post?</p>
                <div class="alert alert-warning">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    <strong>Warning:</strong> This action cannot be undone. All comments and associated data will also be deleted.
                </div>
                <p><strong>Post:</strong> {{ $post->title }}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form action="{{ route('posts.delete', $post->id) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete Post</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    // Show gallery image in modal
    function showGalleryImage(imageUrl, imageNumber) {
        document.getElementById('galleryModalImage').src = imageUrl;
        document.getElementById('galleryImageNumber').textContent = imageNumber;
        document.getElementById('galleryImageName').textContent = 'Image ' + imageNumber;
    }

    // Confirm delete post
    function confirmDelete() {
        var deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
        deleteModal.show();
    }

    // Initialize tooltips
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>


@endsection