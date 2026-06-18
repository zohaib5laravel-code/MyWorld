@extends('frontend.app')
@section('content')

<style>
    .gallery-header {
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

<section class="gallery-header">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center">
                <h1 class="display-4 mb-3">{{ $settings['hero']['title'] }}</h1>
                <p class="lead mb-4">{{ $settings['hero']['description'] }}</p>

                @if($showStats)
                <div class="row justify-content-center g-4 mt-5">
                    <div class="col-md-3 col-6 ">
                         <div class="stats-card pt-1 pb-2 rounded transparentBg" >
                             <div class="stats-number">{{ $pictures->total() }}</div>
                            <div class="stats-label">Total Photos</div>
                        </div>
                    </div>

                    <div class="col-md-3 col-6 ">
                        <div class="stats-card pt-1 pb-2 rounded transparentBg" >
                            <div class="stats-number">{{ $recentPictures->count() }}</div>
                            <div class="stats-label">Recent Uploads</div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>

<section class="main-content py-4">
    <div class="container">
        <div class="row">
            <!-- Gallery Column -->
            <div class="{{ $showSidebar ? 'col-lg-9' : 'col-12' }}">
                <!-- Filter Section -->
                @if($showSortOptions)
                <div class="filter-section">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="d-flex align-items-center justify-content-md-start">
                                <span class="me-3 text-muted d-none d-md-block">Sort by:</span>
                                <select class="form-select form-select-sm w-auto" onchange="window.location.href=this.value">
                                    <option value="{{ route('frontend.gallery', array_merge(request()->except('sort'), ['sort' => 'newest'])) }}"
                                        {{ request('sort', $defaultSort) == 'newest' ? 'selected' : '' }}>
                                        Newest First
                                    </option>
                                    <option value="{{ route('frontend.gallery', array_merge(request()->except('sort'), ['sort' => 'oldest'])) }}"
                                        {{ request('sort') == 'oldest' ? 'selected' : '' }}>
                                        Oldest First
                                    </option>
                                    <option value="{{ route('frontend.gallery', array_merge(request()->except('sort'), ['sort' => 'random'])) }}"
                                        {{ request('sort') == 'random' ? 'selected' : '' }}>
                                        Random
                                    </option>
                                    <option value="{{ route('frontend.gallery', array_merge(request()->except('sort'), ['sort' => 'name'])) }}"
                                        {{ request('sort') == 'name' ? 'selected' : '' }}>
                                        Name A-Z
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Gallery Grid -->
                @if($pictures->count() > 0)
                <div class="{{ $masonryEnabled ? 'masonry-grid' : 'row' }}">
                    @php
                    // Determine grid columns based on settings
                    $gridClass = match($gridColumns) {
                    2 => 'col-md-6',
                    3 => 'col-md-6 col-lg-4',
                    4 => 'col-md-6 col-lg-3',
                    default => 'col-md-6 col-lg-4'
                    };
                    @endphp

                    @foreach($pictures as $index => $picture)
                    @if($masonryEnabled)
                    <div class="masonry-item">
                        <a href="javascript:void(0);"
                            class="gallery-image-link"
                            data-image="{{ asset('assets/pictures/' . $picture->image) }}"
                            data-title="{{ $picture->title }}"
                            data-description="{{ $picture->description }}"
                            data-text-over-img="{{ $picture->title }}"
                            data-date="{{ $picture->created_at->format('M d, Y') }}"
                            data-index="{{ $index }}">
                            <img src="{{ asset('assets/pictures/' . $picture->image) }}"
                                alt="{{ $picture->title }}"
                                class="gallery-img">
                        </a>
                        <div class="gallery-info">
                            <h3 class="gallery-title">{{ $picture->title }}</h3>
                            @if($picture->description)
                            <p class="gallery-description">{{ $picture->description }}</p>
                            @endif
                            <div class="text-muted small mt-2">
                                <i class="far fa-calendar"></i> {{ $picture->created_at->format('M d, Y') }}
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="{{ $gridClass }} mb-4">
                        <div class="card gallery-card h-100">
                            <a href="javascript:void(0);"
                                class="gallery-image-link"
                                data-image="{{ asset('assets/pictures/' . $picture->image) }}"
                                data-title="{{ $picture->title }}"
                                data-description="{{ $picture->description }}"
                                data-text-over-img="{{ $picture->title }}"
                                data-date="{{ $picture->created_at->format('M d, Y') }}"
                                data-index="{{ $index }}">
                                <img src="{{ asset('assets/pictures/' . $picture->image) }}"
                                    alt="{{ $picture->title }}"
                                    class="card-img-top gallery-img">
                            </a>
                            <div class="card-body">
                                <h5 class="card-title">{{ $picture->title }}</h5>
                                @if($picture->description)
                                <p class="card-text">{{ Str::limit($picture->description, 100) }}</p>
                                @endif
                                <div class="text-muted small mt-2">
                                    <i class="far fa-calendar"></i> {{ $picture->created_at->format('M d, Y') }}
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    @endforeach
                </div>

                <!-- Pagination -->
                @if($showPagination && $pictures->hasPages())
                <div class="d-flex justify-content-center mt-5">
                    <nav aria-label="Page navigation">
                        <ul class="pagination">
                            {{-- Previous Page Link --}}
                            @if ($pictures->onFirstPage())
                            <li class="page-item disabled">
                                <span class="page-link">&laquo;</span>
                            </li>
                            @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $pictures->previousPageUrl() }}" rel="prev">&laquo;</a>
                            </li>
                            @endif

                            {{-- Pagination Elements --}}
                            @foreach ($pictures->getUrlRange(1, $pictures->lastPage()) as $page => $url)
                            @if ($page == $pictures->currentPage())
                            <li class="page-item active">
                                <span class="page-link">{{ $page }}</span>
                            </li>
                            @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                            </li>
                            @endif
                            @endforeach

                            {{-- Next Page Link --}}
                            @if ($pictures->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" href="{{ $pictures->nextPageUrl() }}" rel="next">&raquo;</a>
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
                <div class="empty-gallery text-center py-5">
                    <i class="fas fa-images fa-3x text-muted mb-3"></i>
                    <h3 class="mb-3">{{ $settings['empty_state']['title'] }}</h3>
                    <p class="text-muted mb-4">
                        @if(request()->has('category'))
                        {{ $settings['empty_state']['message'] }}
                        @else
                        The gallery is empty. Photos will be added soon!
                        @endif
                    </p>
                    @if(request()->has('category'))
                    <a href="{{ route('frontend.gallery') }}" class="btn btn-primary">
                        <i class="fas fa-times me-2"></i>Clear Filter
                    </a>
                    @endif
                </div>
                @endif
            </div>

            <!-- Sidebar -->
            @if($showSidebar)
            <div class="col-lg-3 mt-4 mt-lg-0">
                <!-- Categories Widget -->
                @if($showCategoriesWidget)
                @include('frontend.components.categories')
                @endif

                <!-- Recent Photos Widget -->
                @if($showRecentPhotosWidget)
                <div class="sidebar-widget mb-4">
                    <h4 class="widget-title">{{ $settings['sidebar']['recent_photos_title'] }}</h4>
                    <div class="row g-2">
                        @php
                        $recentCount = min($settings['sidebar']['recent_photos_count'], 12);
                        $recentPictures = \App\Models\Picture::where('type', 'gallery')
                        ->orderBy('created_at', 'desc')
                        ->limit($recentCount)
                        ->get();
                        @endphp

                        @foreach($recentPictures as $recentPicture)
                        <div class="col-6">
                            <div class="recent-image">
                                <a href="javascript:void(0);"
                                    class="recent-image-link"
                                    data-image="{{ asset('assets/pictures/' . $recentPicture->image) }}"
                                    data-title="{{ $recentPicture->title }}">
                                    <img src="{{ asset('assets/pictures/' . $recentPicture->image) }}"
                                        alt="{{ $recentPicture->title }}">
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Tips Widget -->
                @if($showTipsWidget)
                <div class="sidebar-widget">
                    <h4 class="widget-title">{{ $settings['sidebar']['tips_title'] }}</h4>
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2">
                            <i class="fas fa-search text-primary me-2"></i>
                            <small>Click on any image to view it larger</small>
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-arrows-alt text-primary me-2"></i>
                            <small>Use arrow keys to navigate</small>
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-filter text-primary me-2"></i>
                            <small>Filter by category to find specific photos</small>
                        </li>
                        <li>
                            <i class="fas fa-expand text-primary me-2"></i>
                            <small>Press ESC to exit fullscreen view</small>
                        </li>
                    </ul>
                </div>
                @endif
            </div>
            @endif
        </div>
    </div>
</section>


@if($lightboxEnabled)
<div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-90">
        <div class="modal-content">
            <div class="modal-controls">
                <div class="controls-left">
                    <div class="image-counter">
                        <span id="currentImage">1</span> / <span id="totalImages">{{ $pictures->count() }}</span>
                    </div>
                </div>
                <div class="controls-right">
                    @if($showDownloadBtn)
                    <button class="btn-control" id="downloadBtn" title="Download">
                        <i class="fas fa-download"></i>
                    </button>
                    @endif
                    @if($showFullscreenBtn)
                    <button class="btn-control" id="fullscreenBtn" title="Toggle Fullscreen">
                        <i class="fas fa-expand"></i>
                    </button>
                    @endif
                    <button class="btn-control" data-bs-dismiss="modal" title="Close (ESC)">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>

            <button class="nav-arrow nav-prev" id="prevBtn" title="Previous (←)">
                <i class="fas fa-chevron-left"></i>
            </button>
            <button class="nav-arrow nav-next" id="nextBtn" title="Next (→)">
                <i class="fas fa-chevron-right"></i>
            </button>

            <div class="modal-image-container">
                <div class="image-wrapper">
                    <img id="modalImage" src="" alt="" class="modal-image">
                    <div class="image-overlay"></div>

                    <!-- Image Info Overlay -->
                    <div class="image-info-overlay">
                        <div class="info-content">
                            <h3 id="modalTextOverImg" class="image-title"></h3>
                            <div class="image-meta">
                                <span class="meta-item">
                                    <i class="far fa-calendar"></i>
                                    <span id="modalDate"></span>
                                </span>
                                <span class="meta-item" id="imageResolution"></span>
                            </div>
                        </div>
                    </div>

                    <!-- Loading Spinner -->
                    <div class="image-loading" id="imageLoading">
                        <div class="spinner">
                            <div class="double-bounce1"></div>
                            <div class="double-bounce2"></div>
                        </div>
                        <p>Loading image...</p>
                    </div>
                </div>
            </div>

            @if($showThumbnails)
            <div class="thumbnail-strip">
                <div class="thumbnails-container">
                    @foreach($pictures as $index => $picture)
                    <div class="thumbnail-item" data-index="{{ $index }}">
                        <img src="{{ asset('assets/pictures/' . $picture->image) }}"
                            alt="{{ $picture->title }}"
                            class="thumbnail-img">
                        <div class="thumbnail-overlay"></div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endif

@endsection

@section('scripts')
@if($lightboxEnabled)
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const galleryLinks = document.querySelectorAll('.gallery-image-link');
        const recentLinks = document.querySelectorAll('.recent-image-link');
        const modal = new bootstrap.Modal(document.getElementById('imageModal'));
        const modalImage = document.getElementById('modalImage');
        const modalTextOverImg = document.getElementById('modalTextOverImg');
        const modalDate = document.getElementById('modalDate');
        const imageResolution = document.getElementById('imageResolution');
        const currentImageSpan = document.getElementById('currentImage');
        const totalImagesSpan = document.getElementById('totalImages');
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');
        const imageLoading = document.getElementById('imageLoading');
        const downloadBtn = document.getElementById('downloadBtn');
        const fullscreenBtn = document.getElementById('fullscreenBtn');
        const thumbnailItems = document.querySelectorAll('.thumbnail-item');

        let currentIndex = 0;
        let images = [];
        let isFullscreen = false;

        // Collect all images from gallery
        galleryLinks.forEach((link, index) => {
            const imgData = {
                image: link.getAttribute('data-image'),
                title: link.getAttribute('data-title'),
                description: link.getAttribute('data-description'),
                textOverImg: link.getAttribute('data-text-over-img'),
                date: link.getAttribute('data-date'),
                index: index
            };
            images.push(imgData);

            // Add click event to gallery images
            link.addEventListener('click', () => {
                openModal(imgData);
            });
        });

        // Add click event to recent images
        recentLinks.forEach(link => {
            link.addEventListener('click', () => {
                const imgData = {
                    image: link.getAttribute('data-image'),
                    title: link.getAttribute('data-title'),
                    description: '',
                    textOverImg: '',
                    date: '',
                    index: 0
                };
                openModal(imgData);
            });
        });

        // Add click event to thumbnails if enabled
        if (thumbnailItems.length > 0) {
            thumbnailItems.forEach(item => {
                item.addEventListener('click', () => {
                    const index = parseInt(item.getAttribute('data-index'));
                    if (index >= 0 && index < images.length) {
                        currentIndex = index;
                        updateModalContent(images[currentIndex]);
                    }
                });
            });
        }

        function openModal(imgData) {
            currentIndex = parseInt(imgData.index);
            updateModalContent(imgData);
            modal.show();
            updateThumbnails();
        }

        function updateModalContent(imgData) {
            // Show loading
            if (imageLoading) imageLoading.style.display = 'flex';
            if (modalImage) modalImage.style.opacity = '0';

            // Set image source
            modalImage.src = imgData.image;
            modalTextOverImg.textContent = imgData.textOverImg || '';
            modalDate.textContent = imgData.date || '';

            // Update counters
            currentImageSpan.textContent = currentIndex + 1;
            totalImagesSpan.textContent = images.length;

            // Update thumbnail selection
            updateThumbnails();

            // Get image resolution after load
            const tempImg = new Image();
            tempImg.src = imgData.image;
            tempImg.onload = function() {
                if (imageResolution) {
                    imageResolution.textContent = `${this.width} × ${this.height}`;
                }
            };
        }

        function updateThumbnails() {
            if (thumbnailItems.length > 0) {
                thumbnailItems.forEach((item, index) => {
                    if (index === currentIndex) {
                        item.classList.add('active');
                        // Scroll thumbnail into view
                        item.scrollIntoView({
                            behavior: 'smooth',
                            block: 'nearest',
                            inline: 'center'
                        });
                    } else {
                        item.classList.remove('active');
                    }
                });
            }
        }

        function updateNavigation() {
            if (prevBtn) prevBtn.disabled = currentIndex <= 0;
            if (nextBtn) nextBtn.disabled = currentIndex >= images.length - 1;
        }

        // Image load event
        modalImage.addEventListener('load', function() {
            if (imageLoading) imageLoading.style.display = 'none';
            modalImage.style.opacity = '1';
            updateNavigation();
        });

        // Navigation
        if (prevBtn) {
            prevBtn.addEventListener('click', function() {
                if (currentIndex > 0) {
                    currentIndex--;
                    updateModalContent(images[currentIndex]);
                }
            });
        }

        if (nextBtn) {
            nextBtn.addEventListener('click', function() {
                if (currentIndex < images.length - 1) {
                    currentIndex++;
                    updateModalContent(images[currentIndex]);
                }
            });
        }

        // Download button
        if (downloadBtn) {
            downloadBtn.addEventListener('click', function() {
                const link = document.createElement('a');
                link.href = images[currentIndex].image;
                link.download = images[currentIndex].title || 'image';
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            });
        }

        // Fullscreen button
        if (fullscreenBtn) {
            fullscreenBtn.addEventListener('click', function() {
                const modalContent = document.querySelector('#imageModal .modal-content');

                if (!isFullscreen) {
                    if (modalContent.requestFullscreen) {
                        modalContent.requestFullscreen();
                    } else if (modalContent.webkitRequestFullscreen) {
                        modalContent.webkitRequestFullscreen();
                    } else if (modalContent.msRequestFullscreen) {
                        modalContent.msRequestFullscreen();
                    }
                    fullscreenBtn.innerHTML = '<i class="fas fa-compress"></i>';
                    isFullscreen = true;
                } else {
                    if (document.exitFullscreen) {
                        document.exitFullscreen();
                    } else if (document.webkitExitFullscreen) {
                        document.webkitExitFullscreen();
                    } else if (document.msExitFullscreen) {
                        document.msExitFullscreen();
                    }
                    fullscreenBtn.innerHTML = '<i class="fas fa-expand"></i>';
                    isFullscreen = false;
                }
            });
        }

        // Handle fullscreen change
        document.addEventListener('fullscreenchange', handleFullscreenChange);
        document.addEventListener('webkitfullscreenchange', handleFullscreenChange);
        document.addEventListener('msfullscreenchange', handleFullscreenChange);

        function handleFullscreenChange() {
            if (!document.fullscreenElement && !document.webkitFullscreenElement && !document.msFullscreenElement) {
                if (fullscreenBtn) fullscreenBtn.innerHTML = '<i class="fas fa-expand"></i>';
                isFullscreen = false;
            }
        }

        // Keyboard navigation if enabled
        @if($keyboardNav)
        document.addEventListener('keydown', function(e) {
            if (modal._isShown) {
                switch (e.key) {
                    case 'ArrowLeft':
                        if (currentIndex > 0) {
                            currentIndex--;
                            updateModalContent(images[currentIndex]);
                        }
                        break;
                    case 'ArrowRight':
                        if (currentIndex < images.length - 1) {
                            currentIndex++;
                            updateModalContent(images[currentIndex]);
                        }
                        break;
                    case 'Escape':
                        if (isFullscreen) {
                            // Exit fullscreen first
                            if (document.exitFullscreen) {
                                document.exitFullscreen();
                            }
                        } else {
                            modal.hide();
                        }
                        break;
                    case 'f':
                    case 'F':
                        // Toggle fullscreen
                        if (fullscreenBtn) fullscreenBtn.click();
                        break;
                    case ' ':
                        // Space for next image
                        e.preventDefault();
                        if (nextBtn) nextBtn.click();
                        break;
                }
            }
        });
        @endif

        // Update modal on show
        modal._element.addEventListener('shown.bs.modal', function() {
            updateNavigation();
            // Focus on modal for keyboard events
            this.focus();
        });

        // Smooth image transitions
        modalImage.addEventListener('transitionend', function() {
            if (modalImage.style.opacity === '1') {
                modalImage.style.transform = 'scale(1)';
            }
        });

        const backdrop = document.querySelector('.modal-backdrop');
        if (backdrop) {
            backdrop.style.backgroundColor = 'rgba(0, 0, 0, 0.5)';
            backdrop.style.backdropFilter = 'blur(3px)';
        }
        modal._element.addEventListener('show.bs.modal', function() {
            setTimeout(() => {
                const backdrop = document.querySelector('.modal-backdrop');
                if (backdrop) {
                    backdrop.style.backgroundColor = 'rgba(0, 0, 0, 0.5)';
                    backdrop.style.backdropFilter = 'blur(3px)';
                }
            }, 10);
        });
    });
</script>
@endif
@endsection