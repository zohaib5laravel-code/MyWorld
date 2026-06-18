@extends('frontend.app')
@section('content')

<style>
    .hero-section {
        background: linear-gradient(rgba(21, 26, 34, 0.9),
            rgba(22, 96, 136, 0.9)) {{ "url('{$settings['hero']['hero_bg']}')" }};
        background-size: cover;
        background-position: center;
        color: white;
        padding: 80px 0;
        margin-bottom: 40px;
    }

    .carousel-item img {
        height: {{ $carouselHeight }} px;
        object-fit: cover;
    }

    /* Gallery grid columns */
    @php $gridClass =match($galleryColumns) {
        2=>'col-md-6',
        3=>'col-md-4',
        4=>'col-md-3',
        6=>'col-md-2',
        default=>'col-md-4'
    };

    @endphp .gallery-item {
        margin-bottom: 30px;
    }

    .gallery-item img {
        width: 100%;
        height: 250px;
        object-fit: cover;
        border-radius: 8px;
    }

    .gallery-overlay {
        transition: opacity 0.3s ease;
    }

    .gallery-item:hover .gallery-overlay {
        opacity: 1;
    }
</style>

@if($carouselEnabled)
<section class="banner-carousel">
    <!-- Carousel -->
    <div id="bannerCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-wrap="true" data-bs-interval="{{ $carouselInterval }}">
        @if($showCarouselIndicators)
        <!-- Indicators -->
        <div class="carousel-indicators">
            @foreach($carouselImages as $banner)
            <button
                type="button"
                data-bs-target="#bannerCarousel"
                data-bs-slide-to="{{ $loop->index }}"
                class="{{ $loop->first ? 'active' : '' }}"
                aria-label="Slide {{ $loop->iteration }}">
            </button>
            @endforeach

        </div>
        @endif

        <!-- Carousel Items -->
        <div class="carousel-inner">
            @foreach($carouselImages as $banner)
            <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                <img loading="lazy" src="{{ asset('assets/pictures/' . $banner->image) }}"
                    class="d-block w-100"
                    alt="{{ $banner->title ?? 'Banner Image' }}">
                @if($showCarouselCaptions && $banner->title)
                <div class="carousel-caption d-none d-md-block">
                    <p>{!! $banner->title !!}</p>
                </div>
                @endif
            </div>
            @endforeach

        </div>

        @if($showCarouselControls)
        <!-- Controls -->
        <button class="carousel-control-prev" type="button" data-bs-target="#bannerCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#bannerCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
        @endif
    </div>
</section>
@endif

@if($heroEnabled)
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="display-4 mb-4">{!! $settings['hero']['title'] !!}</h1>
                <p class="lead mb-4">{{ $settings['hero']['subtitle'] }}</p>
                <a href="{{ route('frontend.gallery') }}" class="btn btn-primary btn-lg me-3">
                    <i class="fas fa-images me-2"></i>{{ $settings['hero']['button1_text'] }}
                </a>
                <a href="{{ route('frontend.posts') }}" class="btn btn-outline-light btn-lg">
                    <i class="fas fa-newspaper me-2"></i>{{ $settings['hero']['button2_text'] }}
                </a>
            </div>

            <div class="col-lg-4 text-center">
                <div class="rounded-circle bg-white p-4 d-inline-block">
                    <i class="fas fa-globe-americas text-primary" style="font-size: 6rem;"></i>
                </div>
            </div>
        </div>
    </div>
</section>
@endif

@if($postsEnabled)
<section id="posts" class="py-5 bg-light">
    <div class="container">
        <h2 class="section-title">{{ $settings['posts']['title'] }}</h2>
        @if($settings['posts']['subtitle'])
        <p class="section-subtitle">{{ $settings['posts']['subtitle'] }}</p>
        @endif

        <div class="row">
            @foreach($posts as $post)
            <div class="col-md-4 mb-4">
                <div class="card featured-post shadow-sm h-100">
                    @if($post->featured_image)
                    <img loading="lazy" src="{{ asset('assets/posts/' . $post->featured_image) }}" class="card-img-top" alt="{{ $post->title }}" style="height: 200px; object-fit: cover;">
                    @else
                    <img loading="lazy" src="https://images.unsplash.com/photo-1499750310107-5fef28a66643?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" class="card-img-top" alt="Post Image" style="height: 200px; object-fit: cover;">
                    @endif
                    <div class="card-body">
                        <div class="post-meta mb-2">
                            <i class="far fa-calendar"></i> {{ $post->created_at->format('M d, Y') }}
                            <i class="fas fa-tag ms-3"></i> {{ $post->category->name }}
                        </div>
                        <h5 class="card-title">{{ $post->title }}</h5>
                        <p class="card-text">{!! Str::limit($post->excerpt, 60) !!}</p>
                    </div>
                    <div class="card-footer bg-transparent">
                        <a href="{{ route('frontend.post', $post->slug) }}" class="btn btn-outline-primary">Read More</a>
                    </div>
                </div>
            </div>
            @endforeach

        </div>

        @if($postsShowButton)
        <div class="text-center mt-4">
            <a href="{{ route('frontend.posts') }}" class="btn btn-primary btn-lg">{{ $settings['posts']['button_text']  }}</a>
        </div>
        @endif
    </div>
</section>
@endif

@if($galleryEnabled)
<section id="gallery" class="py-5">
    <div class="container">
        <h2 class="section-title text-center">{{ $settings['gallery']['title']  }}</h2>
        @if($settings['gallery']['subtitle'] )
        <p class="text-center mb-5">{{ $settings['gallery']['subtitle']  }}</p>
        @endif

        <div class="row">
            @foreach($pictures as $image)
            <div class="{{ $gridClass }}">
                <div class="gallery-item shadow">
                    <img loading="lazy" src="{{ asset('assets/pictures/' . $image->image) }}" alt="{{ $image->title }}">
                    @if($image->title)
                    <div class="gallery-overlay position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center bg-dark bg-opacity-50 text-white opacity-0 hover-opacity-100 transition-all">
                        <p class="text-center">{!! $image->title !!}</p>
                    </div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>

        @if($galleryShowButton)
        <div class="text-center mt-4">
            <a href="{{ route('frontend.gallery') }}" class="btn btn-primary btn-lg">{{ $settings['gallery']['button_text'] }}</a>
        </div>
        @endif
    </div>
</section>
@endif

@if($aboutEnabled)
<section class="about-section py-5 bg-light">
    <div class="container">
        <div class="row align-items-center">
            @if($showAboutImage)
            <div class="col-lg-5 mb-4 mb-lg-0">
                <img src="{{ $settings['about']['image'] }}"
                    class="img-fluid rounded shadow"
                    alt="About My World"
                    style="height: 400px; object-fit: cover;">
            </div>
            @endif

            <div class="{{ $showAboutImage ? 'col-lg-7' : 'col-12' }}">
                <h2 class="display-5 mb-4">{{ $settings['about']['title'] }}</h2>
                <p class="lead mb-4">{{ $settings['about']['content'] }}</p>

                @if($showSocialIcons && !empty($settings['about']['social_links']))
                <div class="d-flex gap-3">
                    @foreach($settings['about']['social_links'] as $social)
                    <a href="{{ $social['url'] }}"
                        class="btn btn-outline-primary btn-lg"
                        target="_blank"
                        rel="noopener noreferrer">
                        <i class="{{ $social['icon'] }}"></i>
                    </a>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endif

@endsection

@section('scripts')
<script>
    @if($carouselEnabled)
    const myCarousel = document.querySelector('#bannerCarousel');
    const carousel = new bootstrap.Carousel(myCarousel, {
        interval: {{ $carouselInterval }},
        wrap: true,
        keyboard: true
    });
    @endif
</script>
@endsection