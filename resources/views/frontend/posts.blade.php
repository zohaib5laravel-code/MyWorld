@extends('frontend.app')
@section('content')

<style>
    .page-header {
        background: linear-gradient(rgba(21, 26, 34, 0.9),
            rgba(22, 96, 136, 0.9)),
        url("{{ $settings['hero']['hero_bg'] }}");
        background-size: cover;
        background-position: center;
        color: white;
        padding: 100px 0 60px;
        margin-bottom: 40px;
    }
</style>

<section class="page-header">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center">
                <h1 class="display-4 mb-3">{{ $settings['hero']['title'] }}</h1>
                <p class="lead mb-4">{{ $settings['hero']['description'] }}</p>

                @if($settings['filter']['show_search'])
                <!-- Search Bar -->
                <form action="{{ route('frontend.posts') }}" method="GET" class="row g-2 justify-content-center">
                    <div class="col-lg-6">
                        <div class="input-group">
                            <input type="text"
                                class="form-control form-control-lg"
                                name="search"
                                placeholder="{{ $settings['hero']['search_placeholder'] }}"
                                value="{{ request('search') }}">
                            <button class="btn btn-primary btn-lg" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
                @endif
            </div>
        </div>
    </div>
</section>

<section class="main-content py-4">
    <div class="container">
        <div class="row">
            <!-- Posts Column -->
            <div class="{{ $settings['layout']['show_sidebar'] ? 'col-lg-8' : 'col-12' }}">
                <!-- Filter Section -->
                @if($settings['filter']['show_category_filter'] || $settings['filter']['show_sort_options'])
<div class="filter-section mb-4">
    <div class="row align-items-center">
        @if($settings['filter']['show_category_filter'])
        <div class="col-12 mb-3">
            <div class="d-flex align-items-center flex-wrap">
                <span class="me-3 text-muted mb-2 mb-md-0">Filter:</span>
                <div class="d-flex flex-wrap gap-2 align-items-center">
                    <a href="{{ route('frontend.posts', array_merge(request()->except('category'), ['category' => ''])) }}"
                        class="btn btn-sm {{ !request('category') ? 'btn-primary' : 'btn-outline-primary' }}">
                        All
                    </a>
                    @foreach($categories as $category)
                    <a href="{{ route('frontend.posts', array_merge(request()->except('category'), ['category' => $category->id])) }}"
                        class="btn btn-sm {{ request('category') == $category->id ? 'btn-primary' : 'btn-outline-primary' }}">
                        {{ $category->name }}
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        @if($settings['filter']['show_sort_options'])
        <div class="col-12">
            <div class="d-flex align-items-center justify-content-md-end justify-content-start">
                <span class="me-3 text-muted d-none d-md-block">Sort by:</span>
                <select class="form-select form-select-sm w-auto" onchange="window.location.href=this.value">
                    <option value="{{ route('frontend.posts', array_merge(request()->except('sort'), ['sort' => 'newest'])) }}"
                        {{ request('sort', $settings['filter']['default_sort']) == 'newest' ? 'selected' : '' }}>
                        Newest First
                    </option>
                    <option value="{{ route('frontend.posts', array_merge(request()->except('sort'), ['sort' => 'oldest'])) }}"
                        {{ request('sort') == 'oldest' ? 'selected' : '' }}>
                        Oldest First
                    </option>
                    <option value="{{ route('frontend.posts', array_merge(request()->except('sort'), ['sort' => 'popular'])) }}"
                        {{ request('sort') == 'popular' ? 'selected' : '' }}>
                        Most Popular
                    </option>
                    <option value="{{ route('frontend.posts', array_merge(request()->except('sort'), ['sort' => 'commented'])) }}"
                        {{ request('sort') == 'commented' ? 'selected' : '' }}>
                        Most Commented
                    </option>
                </select>
            </div>
        </div>
        @endif
    </div>
</div>
@endif

                <!-- Posts Grid -->
                @if($posts->count() > 0)
                <div class="row justify-content-center">
                    @php
                    // Determine grid columns based on settings
                    $gridClass = match($settings['layout']['grid_columns']) {
                    2 => 'col-md-6 col-lg-6',
                    3 => 'col-md-6 col-lg-4',
                    4 => 'col-md-6 col-lg-3',
                    default => 'col-md-6 col-lg-6'
                    };
                    @endphp

                    @foreach($posts as $post)

                    <div class="{{ $gridClass }} mb-4">
                        <div class="post-card h-100">
                            <!-- Post featured image -->
                            @if($post->featured_image)
                            <div class="post-card-img-container" style="height: 220px; overflow: hidden;">
                                <img src="{{ asset('assets/posts/' . $post->featured_image) }}"
                                    alt="{{ $post->title }}"
                                    class="post-card-img w-100 h-100 object-fit-cover">
                            </div>
                            @else
                            <div class="post-card-img-container" style="height: 220px; overflow: hidden; background: linear-gradient(135deg, #4a6fa5, #166088);">
                                <div class="d-flex align-items-center justify-content-center h-100">
                                    <i class="fas fa-newspaper text-white" style="font-size: 3rem;"></i>
                                </div>
                            </div>
                            @endif

                            <!-- Post Content -->
                            <div class="post-card-body d-flex flex-column ">
                                @if($post->category)
                                <span class="post-category mb-2">{{ $post->category->name }}</span>
                                @endif

                                <h3 class="post-title flex-grow-1">
                                    <a href="{{ route('frontend.post', $post) }}" class="text-decoration-none text-dark">
                                        {{ Str::limit($post->title, 60) }}
                                    </a>
                                </h3>



                                <div class="post-meta mb-3">
                                    <i class="far fa-calendar"></i> {{ $post->created_at->format('M d, Y') }}
                                    <i class="far fa-eye ms-3"></i> {{ $post->views }}
                                    <i class="far fa-comment ms-3"></i> {{ $post->approvedComments()->count() }}
                                </div>

                                <a href="{{ route('frontend.post', $post->slug) }}" class="btn btn-outline-primary btn-sm mt-auto">
                                    Read More <i class="fas fa-arrow-right ms-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if($settings['pagination']['show_pagination'] && $posts->hasPages())
                <div class="d-flex justify-content-center mt-5">
                    <nav aria-label="Page navigation">
                        <ul class="pagination">
                            {{-- Previous Page Link --}}
                            @if ($posts->onFirstPage())
                            <li class="page-item disabled">
                                <span class="page-link">&laquo;</span>
                            </li>
                            @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $posts->previousPageUrl() }}" rel="prev">&laquo;</a>
                            </li>
                            @endif

                            {{-- Numbered Pagination if enabled --}}
                            @if(in_array($settings['pagination']['type'], ['numbered', 'both']))
                            @foreach ($posts->getUrlRange(1, $posts->lastPage()) as $page => $url)
                            @if ($page == $posts->currentPage())
                            <li class="page-item active">
                                <span class="page-link">{{ $page }}</span>
                            </li>
                            @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                            </li>
                            @endif
                            @endforeach
                            @endif

                            {{-- Next Page Link --}}
                            @if ($posts->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" href="{{ $posts->nextPageUrl() }}" rel="next">&raquo;</a>
                            </li>
                            @else
                            <li class="page-item disabled">
                                <span class="page-link">&raquo;</span>
                            </li>
                            @endif
                        </ul>
                    </nav>
                </div>
                @endif

                @else
                <!-- Empty State -->
                <div class="empty-state text-center py-5">
                    <i class="fas fa-newspaper fa-3x text-muted mb-3"></i>
                    <h3 class="mb-3">{{ $settings['empty_state']['title'] }}</h3>
                    <p class="text-muted mb-4">
                        @if(request()->has('search') || request()->has('category'))
                        {{ $settings['empty_state']['message'] }}
                        @else
                        No posts have been published yet. Check back soon!
                        @endif
                    </p>
                    @if(request()->has('search') || request()->has('category'))
                    <a href="{{ route('frontend.posts') }}" class="btn btn-primary">
                        <i class="fas fa-times me-2"></i>Clear Filters
                    </a>
                    @endif
                </div>
                @endif
            </div>

            <!-- Sidebar -->
            @if($settings['layout']['show_sidebar'])
            <div class="col-lg-4 mt-4 mt-lg-0">
                <!-- About Widget -->
                @if($settings['sidebar']['show_about_widget'])
                <div class="sidebar-widget mb-4">
                    <h4 class="widget-title">{{ $settings['sidebar']['about_widget_title'] }}</h4>
                    <p>{{ $settings['sidebar']['about_widget_content'] }}</p>
                </div>
                @endif

                <!-- Categories Widget -->
                @if($settings['sidebar']['show_categories_widget'])
                @include('frontend.components.categories')
                @endif

                <!-- Popular Posts Widget -->
                @if($settings['sidebar']['show_popular_posts_widget'])
                <div class="sidebar-widget mb-4">
                    <h4 class="widget-title">{{ $settings['sidebar']['popular_posts_title'] }}</h4>
                    @php
                    // Get popular posts based on settings
                    $popularPosts = \App\Models\Post::where('status', 'published')
                    ->orderBy('views', 'desc')
                    ->limit($settings['sidebar']['popular_posts_count'])
                    ->get();
                    @endphp

                    @foreach($popularPosts as $popularPost)
                    <div class="popular-post mb-3">
                        @if($popularPost->featured_image)
                        <img src="{{ asset('assets/posts/' . $popularPost->featured_image) }}"
                            alt="{{ $popularPost->title }}"
                            class="popular-post-img">
                        @else
                        <div class="popular-post-img d-flex align-items-center justify-content-center"
                            style="background: linear-gradient(135deg, #4a6fa5, #166088);">
                            <i class="fas fa-newspaper text-white"></i>
                        </div>
                        @endif
                        <div>
                            <h6 class="mb-1">
                                <a href="{{ route('frontend.post', $popularPost) }}"
                                    class="text-decoration-none text-dark">
                                    {{ Str::limit($popularPost->title, 40) }}
                                </a>
                            </h6>
                            <small class="text-muted">
                                <i class="far fa-eye"></i> {{ $popularPost->views }} views
                            </small>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif

                <!-- Newsletter Widget -->
                @if($settings['sidebar']['show_newsletter_widget'])
                @include('frontend.components.newsletter')
                @endif
            </div>
            @endif
        </div>
    </div>
</section>

@endsection