@extends('admin.app')

@section('content')
<main class="app-main">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-gradient-primary py-3">
                        <h4 class="mb-0"><i class="fas fa-home me-2"></i>Homepage Settings</h4>
                        <small class="opacity-75">Customize your homepage layout and content</small>
                    </div>

                    <form action="{{ route('settings.homepage.update') }}" method="POST" id="homepageForm" enctype="multipart/form-data">
                        @csrf

                        <div class="card-body">
                            @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show mb-4">
                                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                            @endif

                            @if($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show mb-4">
                                <h6 class="alert-heading"><i class="fas fa-exclamation-triangle me-2"></i>Validation Errors</h6>
                                <ul class="mb-0 ps-3 mt-2">
                                    @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                            @endif

                            {{-- Page Status --}}
                            <div class="card border mb-4">
                                <div class="card-header bg-light py-2">
                                    <h6 class="mb-0"><i class="fas fa-toggle-on me-2"></i>Status</h6>
                                </div>
                                <div class="card-body p-3">
                                    <select name="status" class="form-select form-select-sm w-auto" required>
                                        <option value="1" {{ $status ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ !$status ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                    <small class="text-muted ms-2">When inactive, visitors see maintenance page</small>
                                </div>
                            </div>

                            {{-- Hero Section --}}
                            <div class="card border mb-4">
                                <div class="card-header bg-light py-2 d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0"><i class="fas fa-star me-2"></i>Hero Section</h6>
                                    <div class="form-check form-switch m-0">
                                        <input type="hidden" name="hero[enabled]" value="0">
                                        <input class="form-check-input" type="checkbox" name="hero[enabled]" value="1"
                                            {{ isset($homepageData['hero']['enabled']) && $homepageData['hero']['enabled'] == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label small">Enable Section</label>
                                    </div>
                                </div>
                                <div class="card-body p-3">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <div class="image-upload-wrapper">
                                                <label class="form-label small fw-bold mb-1">Background Image</label>
                                                <div class="image-preview mb-2" id="heroBgPreview">
                                                    @if(!empty($homepageData['hero']['hero_bg']))
                                                    <img src="{{ asset('assets/homepage/' . $homepageData['hero']['hero_bg']) }}"
                                                        class="img-fluid rounded" style="max-height: 120px;">
                                                    <div class="mt-1">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="remove_images[hero_bg]" value="1" id="removeHeroBg">
                                                            <label class="form-check-label text-danger small" for="removeHeroBg">Remove</label>
                                                        </div>
                                                    </div>
                                                    @else
                                                    <div class="border rounded p-3 text-center bg-light">
                                                        <i class="fas fa-image fa-2x text-muted mb-2"></i>
                                                        <p class="mb-0 text-muted small">No image</p>
                                                    </div>
                                                    @endif
                                                </div>
                                                <input type="file" name="hero_bg_image" class="form-control form-control-sm" id="heroBgInput" accept="image/*">
                                                <input type="hidden" name="current_images[hero_bg]" value="{{ $homepageData['hero']['hero_bg'] ?? '' }}">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="mb-2">
                                                <label class="form-label small fw-bold mb-1">Title</label>
                                                <input type="text" name="hero[title]" class="form-control form-control-sm"
                                                    value="{{ old('hero.title', $homepageData['hero']['title'] ?? 'Welcome to My World') }}">
                                            </div>
                                            <div class="mb-2">
                                                <label class="form-label small fw-bold mb-1">Subtitle</label>
                                                <textarea name="hero[subtitle]" class="form-control form-control-sm" rows="2">{{ old('hero.subtitle', $homepageData['hero']['subtitle'] ?? '') }}</textarea>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="mb-2">
                                                <label class="form-label small fw-bold mb-1">Primary Button Text</label>
                                                <input type="text" name="hero[button1_text]" class="form-control form-control-sm"
                                                    value="{{ old('hero.button1_text', $homepageData['hero']['button1_text'] ?? 'Explore Gallery') }}">
                                            </div>
                                            <div class="mb-2">
                                                <label class="form-label small fw-bold mb-1">Primary Button URL</label>
                                                <input type="text" name="hero[button1_url]" class="form-control form-control-sm"
                                                    value="{{ old('hero.button1_url', $homepageData['hero']['button1_url'] ?? '#gallery') }}">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="mb-2">
                                                <label class="form-label small fw-bold mb-1">Secondary Button Text</label>
                                                <input type="text" name="hero[button2_text]" class="form-control form-control-sm"
                                                    value="{{ old('hero.button2_text', $homepageData['hero']['button2_text'] ?? 'Read Posts') }}">
                                            </div>
                                            <div class="mb-2">
                                                <label class="form-label small fw-bold mb-1">Secondary Button URL</label>
                                                <input type="text" name="hero[button2_url]" class="form-control form-control-sm"
                                                    value="{{ old('hero.button2_url', $homepageData['hero']['button2_url'] ?? '#posts') }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Carousel Settings --}}
                            <div class="card border mb-4">
                                <div class="card-header bg-light py-2">
                                    <h6 class="mb-0"><i class="fas fa-images me-2"></i>Banner Carousel</h6>
                                </div>
                                <div class="card-body p-3">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-check form-switch mb-2">
                                                <input type="hidden" name="carousel[enabled]" value="0">
                                                <input class="form-check-input" type="checkbox" name="carousel[enabled]" value="1"
                                                    {{ isset($homepageData['carousel']['enabled']) && $homepageData['carousel']['enabled'] == 1 ? 'checked' : '' }}>
                                                <label class="form-check-label small">Enable Carousel</label>
                                            </div>
                                            <div class="form-check form-switch mb-2">
                                                <input type="hidden" name="carousel[show_indicators]" value="0">
                                                <input class="form-check-input" type="checkbox" name="carousel[show_indicators]" value="1"
                                                    {{ isset($homepageData['carousel']['show_indicators']) && $homepageData['carousel']['show_indicators'] == 1 ? 'checked' : '' }}>
                                                <label class="form-check-label small">Show Indicators</label>
                                            </div>
                                            <div class="form-check form-switch mb-2">
                                                <input type="hidden" name="carousel[show_captions]" value="0">
                                                <input class="form-check-input" type="checkbox" name="carousel[show_captions]" value="1"
                                                    {{ isset($homepageData['carousel']['show_captions']) && $homepageData['carousel']['show_captions'] == 1 ? 'checked' : '' }}>
                                                <label class="form-check-label small">Show Captions</label>
                                            </div>
                                            <div class="form-check form-switch mb-2">
                                                <input type="hidden" name="carousel[show_controls]" value="0">
                                                <input class="form-check-input" type="checkbox" name="carousel[show_controls]" value="1"
                                                    {{ isset($homepageData['carousel']['show_controls']) && $homepageData['carousel']['show_controls'] == 1 ? 'checked' : '' }}>
                                                <label class="form-check-label small">Show Controls</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-2">
                                                <label class="form-label small fw-bold mb-1">Interval (ms)</label>
                                                <input type="number" name="carousel[interval]" class="form-control form-control-sm"
                                                    value="{{ old('carousel.interval', $homepageData['carousel']['interval'] ?? 5000) }}" min="1000" max="10000">
                                            </div>
                                            <div class="mb-2">
                                                <label class="form-label small fw-bold mb-1">Height (px)</label>
                                                <input type="number" name="carousel[height]" class="form-control form-control-sm"
                                                    value="{{ old('carousel.height', $homepageData['carousel']['height'] ?? 500) }}" min="300" max="800">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Posts Section --}}
                            <div class="card border mb-4">
                                <div class="card-header bg-light py-2">
                                    <h6 class="mb-0"><i class="fas fa-newspaper me-2"></i>Recent Posts</h6>
                                </div>
                                <div class="card-body p-3">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-check form-switch mb-2">
                                                <input type="hidden" name="posts[enabled]" value="0">
                                                <input class="form-check-input" type="checkbox" name="posts[enabled]" value="1"
                                                    {{ isset($homepageData['posts']['enabled']) && $homepageData['posts']['enabled'] == 1 ? 'checked' : '' }}>
                                                <label class="form-check-label small">Enable Section</label>
                                            </div>
                                            <div class="form-check form-switch mb-2">
                                                <input type="hidden" name="posts[show_button]" value="0">
                                                <input class="form-check-input" type="checkbox" name="posts[show_button]" value="1"
                                                    {{ isset($homepageData['posts']['show_button']) && $homepageData['posts']['show_button'] == 1 ? 'checked' : '' }}>
                                                <label class="form-check-label small">Show "View All" Button</label>
                                            </div>
                                            <div class="mb-2">
                                                <label class="form-label small fw-bold mb-1">Posts to Show</label>
                                                <input type="number" name="posts[posts_count]" class="form-control form-control-sm"
                                                    value="{{ old('posts.posts_count', $homepageData['posts']['posts_count'] ?? 3) }}" min="1" max="12">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-2">
                                                <label class="form-label small fw-bold mb-1">Section Title</label>
                                                <input type="text" name="posts[title]" class="form-control form-control-sm"
                                                    value="{{ old('posts.title', $homepageData['posts']['title'] ?? 'Recent Posts') }}">
                                            </div>
                                            <div class="mb-2">
                                                <label class="form-label small fw-bold mb-1">Button Text</label>
                                                <input type="text" name="posts[button_text]" class="form-control form-control-sm"
                                                    value="{{ old('posts.button_text', $homepageData['posts']['button_text'] ?? 'View All Posts') }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Gallery Section --}}
                            <div class="card border mb-4">
                                <div class="card-header bg-light py-2">
                                    <h6 class="mb-0"><i class="fas fa-camera me-2"></i>Gallery</h6>
                                </div>
                                <div class="card-body p-3">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-check form-switch mb-2">
                                                <input type="hidden" name="gallery[enabled]" value="0">
                                                <input class="form-check-input" type="checkbox" name="gallery[enabled]" value="1"
                                                    {{ isset($homepageData['gallery']['enabled']) && $homepageData['gallery']['enabled'] == 1 ? 'checked' : '' }}>
                                                <label class="form-check-label small">Enable Section</label>
                                            </div>
                                            <div class="mb-2">
                                                <label class="form-label small fw-bold mb-1">Images to Show</label>
                                                <input type="number" name="gallery[images_count]" class="form-control form-control-sm"
                                                    value="{{ old('gallery.images_count', $homepageData['gallery']['images_count'] ?? 6) }}" min="1" max="12">
                                            </div>
                                            <div class="mb-2">
                                                <label class="form-label small fw-bold mb-1">Columns</label>
                                                <select name="gallery[columns]" class="form-select form-select-sm">
                                                    <option value="2" {{ old('gallery.columns', $homepageData['gallery']['columns'] ?? 3) == 2 ? 'selected' : '' }}>2 Columns</option>
                                                    <option value="3" {{ old('gallery.columns', $homepageData['gallery']['columns'] ?? 3) == 3 ? 'selected' : '' }}>3 Columns</option>
                                                    <option value="4" {{ old('gallery.columns', $homepageData['gallery']['columns'] ?? 3) == 4 ? 'selected' : '' }}>4 Columns</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-2">
                                                <label class="form-label small fw-bold mb-1">Section Title</label>
                                                <input type="text" name="gallery[title]" class="form-control form-control-sm"
                                                    value="{{ old('gallery.title', $homepageData['gallery']['title'] ?? 'Photo Gallery') }}">
                                            </div>
                                            <div class="mb-2">
                                                <label class="form-label small fw-bold mb-1">Button Text</label>
                                                <input type="text" name="gallery[button_text]" class="form-control form-control-sm"
                                                    value="{{ old('gallery.button_text', $homepageData['gallery']['button_text'] ?? 'View Full Gallery') }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- About Section --}}
                            {{-- About Section --}}
                            <div class="card border mb-4">
                                <div class="card-header bg-light py-2">
                                    <h6 class="mb-0"><i class="fas fa-info-circle me-2"></i>About Section</h6>
                                </div>
                                <div class="card-body p-3">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-check form-switch mb-2">
                                                <input type="hidden" name="about[enabled]" value="0">
                                                <input class="form-check-input" type="checkbox" name="about[enabled]" value="1"
                                                    {{ isset($homepageData['about']['enabled']) && $homepageData['about']['enabled'] == 1 ? 'checked' : '' }}>
                                                <label class="form-check-label small">Enable Section</label>
                                            </div>
                                            <div class="form-check form-switch mb-2">
                                                <input type="hidden" name="about[show_image]" value="0">
                                                <input class="form-check-input" type="checkbox" name="about[show_image]" value="1"
                                                    {{ isset($homepageData['about']['show_image']) && $homepageData['about']['show_image'] == 1 ? 'checked' : '' }}>
                                                <label class="form-check-label small">Show Image</label>
                                            </div>

                                            {{-- Image Upload Field (Replaced URL field) --}}
                                            <div class="image-upload-wrapper">
                                                <label class="form-label small fw-bold mb-1">About Image</label>
                                                <div class="image-preview mb-2" id="aboutImagePreview">
                                                    @if(!empty($homepageData['about']['image']))
                                                    <img src="{{ asset('assets/homepage/' . $homepageData['about']['image']) }}"
                                                        class="img-fluid rounded" style="max-height: 120px;">
                                                    <div class="mt-1">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="remove_images[about]" value="1" id="removeAboutImage">
                                                            <label class="form-check-label text-danger small" for="removeAboutImage">Remove</label>
                                                        </div>
                                                    </div>
                                                    @else
                                                    <div class="border rounded p-3 text-center bg-light">
                                                        <i class="fas fa-image fa-2x text-muted mb-2"></i>
                                                        <p class="mb-0 text-muted small">No image</p>
                                                    </div>
                                                    @endif
                                                </div>
                                                <input type="file" name="about_image" class="form-control form-control-sm" id="aboutImageInput" accept="image/*">
                                                <input type="hidden" name="current_images[about]" value="{{ $homepageData['about']['image'] ?? '' }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-2">
                                                <label class="form-label small fw-bold mb-1">Section Title</label>
                                                <input type="text" name="about[title]" class="form-control form-control-sm"
                                                    value="{{ old('about.title', $homepageData['about']['title'] ?? 'About My World') }}">
                                            </div>
                                            <div class="mb-2">
                                                <label class="form-label small fw-bold mb-1">Content</label>
                                                <textarea name="about[content]" class="form-control form-control-sm" rows="3">{{ old('about.content', $homepageData['about']['content'] ?? '') }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- SEO Settings --}}
                            <div class="card border">
                                <div class="card-header bg-light py-2">
                                    <h6 class="mb-0"><i class="fas fa-search me-2"></i>SEO Settings</h6>
                                </div>
                                <div class="card-body p-3">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-2">
                                                <label class="form-label small fw-bold mb-1">Meta Title</label>
                                                <input type="text" name="meta[meta_title]" class="form-control form-control-sm"
                                                    value="{{ old('meta.meta_title', $homepageData['meta']['meta_title'] ?? 'My World | Personal Blog & Gallery') }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-2">
                                                <label class="form-label small fw-bold mb-1">Meta Description</label>
                                                <textarea name="meta[meta_description]" class="form-control form-control-sm" rows="2">{{ old('meta.meta_description', $homepageData['meta']['meta_description'] ?? '') }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer bg-light border-top py-3">
                            <div class="d-flex justify-content-between">
                                <button type="reset" class="btn btn-outline-secondary btn-sm">
                                    <i class="fas fa-undo me-1"></i> Reset
                                </button>
                                <button type="submit" class="btn btn-primary btn-sm">
                                    <i class="fas fa-save me-1"></i> Save Settings
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>


@endsection



@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Image preview for hero background
        const heroBgInput = document.getElementById('heroBgInput');
        const heroBgPreview = document.getElementById('heroBgPreview');

        if (heroBgInput && heroBgPreview) {
            heroBgInput.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        heroBgPreview.innerHTML = `
                        <img src="${e.target.result}" class="img-fluid rounded" style="max-height: 120px;">
                        <div class="mt-1">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remove_images[hero_bg]" value="1" id="removeHeroBg">
                                <label class="form-check-label text-danger small" for="removeHeroBg">Remove</label>
                            </div>
                        </div>
                    `;
                    };
                    reader.readAsDataURL(this.files[0]);
                }
            });
        }

        // Image preview for about image
        const aboutImageInput = document.getElementById('aboutImageInput');
        const aboutImagePreview = document.getElementById('aboutImagePreview');

        if (aboutImageInput && aboutImagePreview) {
            aboutImageInput.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        aboutImagePreview.innerHTML = `
                    <img src="${e.target.result}" class="img-fluid rounded" style="max-height: 120px;">
                    <div class="mt-1">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remove_images[about]" value="1" id="removeAboutImage">
                            <label class="form-check-label text-danger small" for="removeAboutImage">Remove</label>
                        </div>
                    </div>
                `;
                    };
                    reader.readAsDataURL(this.files[0]);
                }
            });
        }

        window.dispatchEvent(new Event('scroll'));
    });
</script>
@endsection