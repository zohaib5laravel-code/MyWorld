@extends('admin/app')
@section('content')

<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Dashboard</h3>
                    <p class="text-muted mb-0">Welcome back, {{ Auth::user()->name ?? 'Admin' }}!</p>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <!-- Stats Cards -->
            <div class="row mb-4">
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-start border-primary border-4 shadow-sm h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col me-2">
                                    <div class="text-xs fw-bold text-primary text-uppercase mb-1">
                                        Total Posts</div>
                                    <div class="h5 mb-0 fw-bold text-gray-800">{{ $stats['total_posts'] ?? 0 }}</div>
                                    <div class="mt-2 mb-0 text-muted text-xs">
                                        <span class="text-success me-2">
                                            <i class="fas fa-arrow-up me-1"></i>{{ $stats['posts_growth'] ?? 0 }}%
                                        </span>
                                        <span>Since last month</span>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-newspaper fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent border-top-0">
                            <a href="{{ route('posts.index') }}" class="text-decoration-none small">
                                View Details <i class="fas fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-start border-success border-4 shadow-sm h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col me-2">
                                    <div class="text-xs fw-bold text-success text-uppercase mb-1">
                                        Total Views</div>
                                    <div class="h5 mb-0 fw-bold text-gray-800">{{ number_format($stats['total_views'] ?? 0) }}</div>
                                    <div class="mt-2 mb-0 text-muted text-xs">
                                        <span class="text-success me-2">
                                            <i class="fas fa-eye me-1"></i>{{ $stats['daily_views'] ?? 0 }} today
                                        </span>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-eye fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent border-top-0">
                            <a href="{{ route('posts.index') }}" class="text-decoration-none small">
                                Analytics <i class="fas fa-chart-line ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-start border-info border-4 shadow-sm h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col me-2">
                                    <div class="text-xs fw-bold text-info text-uppercase mb-1">
                                        Categories</div>
                                    <div class="h5 mb-0 fw-bold text-gray-800">{{ $stats['total_categories'] ?? 0 }}</div>
                                    <div class="mt-2 mb-0 text-muted text-xs">
                                        <span class="text-info me-2">
                                            <i class="fas fa-tags me-1"></i>{{ $stats['active_categories'] ?? 0 }} active
                                        </span>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-folder fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent border-top-0">
                            <a href="{{ route('categories.index') }}" class="text-decoration-none small">
                                Manage Categories <i class="fas fa-cog ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-start border-warning border-4 shadow-sm h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col me-2">
                                    <div class="text-xs fw-bold text-warning text-uppercase mb-1">
                                        Pictures/Gallery</div>
                                    <div class="h5 mb-0 fw-bold text-gray-800">{{ $stats['total_pictures'] ?? 0 }}</div>
                                    <div class="mt-2 mb-0 text-muted text-xs">
                                        <span class="text-warning me-2">
                                            <i class="fas fa-image me-1"></i>{{ $stats['pictures_by_type']['gallery'] ?? 0 }} gallery
                                        </span>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-images fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent border-top-0">
                            <a href="{{ route('pictures.index') }}" class="text-decoration-none small">
                                View Gallery <i class="fas fa-images ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Recent Posts -->
                <div class="col-xl-8 col-lg-7">
                    <div class="card shadow-sm mb-4">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 fw-bold text-primary">Recent Posts</h6>
                            <a href="{{ route('posts.create') }}" class="btn btn-sm btn-primary ms-auto">
                                <i class="fas fa-plus me-1"></i>New Post
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Title</th>
                                            <th>Category</th>
                                            <th>Status</th>
                                            <th>Views</th>
                                            <th>Published</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($recentPosts as $post)
                                        <tr>
                                            <td>
                                                <a href="{{ route('posts.show', $post->id) }}" class="text-decoration-none">
                                                    {{ Str::limit($post->title, 40) }}
                                                </a>
                                            </td>
                                            <td>
                                                @if($post->category)
                                                <span class="badge bg-info">{{ $post->category->name }}</span>
                                                @else
                                                <span class="badge bg-secondary">Uncategorized</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($post->status == 'published')
                                                <span class="badge bg-success">Published</span>
                                                @elseif($post->status == 'draft')
                                                <span class="badge bg-warning">Draft</span>
                                                @else
                                                <span class="badge bg-secondary">Archived</span>
                                                @endif
                                            </td>
                                            <td>{{ number_format($post->views) }}</td>
                                            <td>{{ $post->published_at ? date('M d, Y', strtotime($post->published_at))  : 'Not published' }}</td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-outline-primary">
                                                        <i class="bi bi-pencil-square""></i>
                                                    </a>
                                                
                                                    
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-4">
                                                <i class="fas fa-newspaper fa-3x text-muted mb-3"></i>
                                                <p class="text-muted">No posts yet. Create your first post!</p>
                                                <a href="{{ route('posts.create') }}" class="btn btn-primary">
                                                    <i class="fas fa-plus me-1"></i>Create Post
                                                </a>
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="text-end mt-3">
                                <a href="{{ route('posts.index') }}" class="btn btn-outline-primary btn-sm">
                                    View All Posts <i class="fas fa-arrow-right ms-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Popular Posts by Views -->
                    <div class="card shadow-sm">
                        <div class="card-header py-3">
                            <h6 class="m-0 fw-bold text-primary">Most Popular Posts</h6>
                        </div>
                        <div class="card-body">
                            <div class="list-group">
                                @forelse($popularPosts as $index => $post)
                                <div class="list-group-item list-group-item-action border-0 rounded-0 py-3">
                                    <div class="d-flex w-100 justify-content-between align-items-center">
                                        <div class="me-3">
                                            <span class="badge bg-primary me-2">{{ $index + 1 }}</span>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1">
                                                <a href="{{ route('posts.show', $post->id) }}" class="text-decoration-none">
                                                    {{ Str::limit($post->title, 50) }}
                                                </a>
                                            </h6>
                                            <small class="text-muted">
                                                <i class="fas fa-eye me-1"></i>{{ number_format($post->views) }} views •
                                                <i class="fas fa-calendar me-1"></i>{{ date('M d, Y', strtotime($post->published_at))  }}
                                            </small>
                                        </div>
                                        <div>
                                            <span class="badge bg-info">{{ $post->category->name ?? 'Uncategorized' }}</span>
                                        </div>
                                    </div>
                                </div>
                                @empty
                                <div class="text-center py-4">
                                    <i class="fas fa-chart-line fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">No views data available yet</p>
                                </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Sidebar -->
                <div class="col-xl-4 col-lg-5">
                    <!-- Post Status Summary -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 fw-bold text-primary">Post Status Summary</h6>
                        </div>
                        <div class="card-body">
                            <div class="row text-center">
                                <div class="col-4">
                                    <div class="border rounded-circle d-inline-flex align-items-center justify-content-center" 
                                         style="width: 80px; height: 80px; background-color: rgba(13, 110, 253, 0.1);">
                                        <div>
                                            <div class="h4 mb-0 text-primary">{{ $stats['published_posts'] ?? 0 }}</div>
                                            <small class="text-muted">Published</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="border rounded-circle d-inline-flex align-items-center justify-content-center" 
                                         style="width: 80px; height: 80px; background-color: rgba(255, 193, 7, 0.1);">
                                        <div>
                                            <div class="h4 mb-0 text-warning">{{ $stats['draft_posts'] ?? 0 }}</div>
                                            <small class="text-muted">Draft</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="border rounded-circle d-inline-flex align-items-center justify-content-center" 
                                         style="width: 80px; height: 80px; background-color: rgba(108, 117, 125, 0.1);">
                                        <div>
                                            <div class="h4 mb-0 text-secondary">{{ $stats['archived_posts'] ?? 0 }}</div>
                                            <small class="text-muted">Archived</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4">
                                <div class="d-flex justify-content-between mb-1">
                                    <span>Published</span>
                                    <span>{{ $stats['published_posts'] ?? 0 }} posts</span>
                                </div>
                                <div class="progress mb-3" style="height: 10px;">
                                    <div class="progress-bar bg-primary" role="progressbar" 
                                         style="width: {{ $stats['published_percentage'] ?? 0 }}%" 
                                         aria-valuenow="{{ $stats['published_posts'] ?? 0 }}" 
                                         aria-valuemin="0" 
                                         aria-valuemax="{{ $stats['total_posts'] ?? 1 }}">
                                    </div>
                                </div>
                                
                                <div class="d-flex justify-content-between mb-1">
                                    <span>Drafts</span>
                                    <span>{{ $stats['draft_posts'] ?? 0 }} posts</span>
                                </div>
                                <div class="progress mb-3" style="height: 10px;">
                                    <div class="progress-bar bg-warning" role="progressbar" 
                                         style="width: {{ $stats['draft_percentage'] ?? 0 }}%" 
                                         aria-valuenow="{{ $stats['draft_posts'] ?? 0 }}" 
                                         aria-valuemin="0" 
                                         aria-valuemax="{{ $stats['total_posts'] ?? 1 }}">
                                    </div>
                                </div>
                                
                                <div class="d-flex justify-content-between mb-1">
                                    <span>Archived</span>
                                    <span>{{ $stats['archived_posts'] ?? 0 }} posts</span>
                                </div>
                                <div class="progress" style="height: 10px;">
                                    <div class="progress-bar bg-secondary" role="progressbar" 
                                         style="width: {{ $stats['archived_percentage'] ?? 0 }}%" 
                                         aria-valuenow="{{ $stats['archived_posts'] ?? 0 }}" 
                                         aria-valuemin="0" 
                                         aria-valuemax="{{ $stats['total_posts'] ?? 1 }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 fw-bold text-primary">Quick Actions</h6>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-6">
                                    <a href="{{ route('posts.create') }}" class="btn btn-outline-primary w-100 py-3 d-flex flex-column align-items-center">
                                        <i class="fas fa-plus-circle fa-2x mb-2"></i>
                                        <span>New Post</span>
                                    </a>
                                </div>
                                <div class="col-6">
                                    <a href="{{ route('pictures.create') }}" class="btn btn-outline-success w-100 py-3 d-flex flex-column align-items-center">
                                        <i class="fas fa-image fa-2x mb-2"></i>
                                        <span>Add Picture</span>
                                    </a>
                                </div>
                                <div class="col-6">
                                    <a href="{{ route('categories.index') }}" class="btn btn-outline-info w-100 py-3 d-flex flex-column align-items-center">
                                        <i class="fas fa-folder fa-2x mb-2"></i>
                                        <span>Categories</span>
                                    </a>
                                </div>
                                <div class="col-6">
                                    <a href="{{ route('pictures.index') }}" class="btn btn-outline-warning w-100 py-3 d-flex flex-column align-items-center">
                                        <i class="fas fa-images fa-2x mb-2"></i>
                                        <span>Gallery</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Pictures -->
                    <div class="card shadow-sm">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                            <h6 class="m-0 fw-bold text-primary">Recent Pictures</h6>
                            <a href="{{ route('pictures.index') }}" class="small  ms-auto">View All</a>
                        </div>
                        <div class="card-body">
                            <div class="row g-2">
                                @forelse($recentPictures as $picture)
                                <div class="col-4">
                                    <div class="position-relative">
                                        <img src="{{ asset('assets/pictures/' . $picture->image) }}" 
                                             alt="{{ $picture->title }}" 
                                             class="img-fluid rounded border"
                                             style="height: 80px; width: 100%; object-fit: cover;">
                                        <span class="badge bg-{{ $picture->status ? 'success' : 'secondary' }} position-absolute top-0 end-0 m-1"
                                              style="font-size: 0.6rem;">
                                            {{ $picture->status ? 'Active' : 'Inactive' }}
                                        </span>
                                    </div>
                                    <small class="d-block text-center mt-1 text-truncate">{{ $picture->title ?: 'No title' }}</small>
                                </div>
                                @empty
                                <div class="col-12 text-center py-3">
                                    <i class="fas fa-image fa-2x text-muted mb-2"></i>
                                    <p class="text-muted small">No pictures uploaded yet</p>
                                </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        
        </div>
    </div>
</main>



<style>
    .card {
        border: none;
        transition: transform 0.2s ease-in-out;
    }
    
    .card:hover {
        transform: translateY(-2px);
    }
    
    .border-start {
        border-left-width: 0.25rem !important;
    }
    
    .timeline {
        position: relative;
    }
    
    .timeline::before {
        content: '';
        position: absolute;
        left: 18px;
        top: 0;
        bottom: 0;
        width: 2px;
        background: #e9ecef;
    }
    
    .timeline-item {
        position: relative;
    }
    
    .timeline-marker {
        position: absolute;
        left: 0;
        top: 0;
        width: 20px;
        height: 20px;
        border: 3px solid #fff;
        z-index: 1;
    }
    
    .timeline-content {
        flex: 1;
    }
    
    .progress {
        border-radius: 10px;
    }
    
    .progress-bar {
        border-radius: 10px;
    }
    
    .list-group-item:hover {
        background-color: rgba(13, 110, 253, 0.05);
    }
    
    .btn-outline-primary, .btn-outline-success, .btn-outline-info, .btn-outline-warning {
        transition: all 0.3s ease;
    }
    
    .btn-outline-primary:hover {
        background-color: #0d6efd;
        color: white;
    }
    
    .btn-outline-success:hover {
        background-color: #198754;
        color: white;
    }
    
    .btn-outline-info:hover {
        background-color: #0dcaf0;
        color: white;
    }
    
    .btn-outline-warning:hover {
        background-color: #ffc107;
        color: black;
    }
</style>
@endsection