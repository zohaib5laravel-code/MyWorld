{{-- resources/views/admin/settings/gallery.blade.php --}}
@extends('admin.app')

@section('content')
<main class="app-main">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-gradient-primary py-3">
                        <h4 class="mb-0"><i class="fas fa-images me-2"></i>Gallery Page Settings</h4>
                        <small class="opacity-75">Customize your photo gallery page</small>
                    </div>
                    
                    <form action="{{ route('settings.gallery.update') }}" method="POST" id="galleryForm" enctype="multipart/form-data">
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
                                    <small class="text-muted ms-2">When inactive, page shows maintenance message</small>
                                </div>
                            </div>
                            
                            {{-- Hero Section --}}
                            <div class="card border mb-4">
                                <div class="card-header bg-light py-2">
                                    <h6 class="mb-0"><i class="fas fa-heading me-2"></i>Hero Section</h6>
                                </div>
                                <div class="card-body p-3">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label small fw-bold mb-1">Hero Background</label>
                                            <div class="image-upload-wrapper">
                                                <div class="image-preview mb-2" id="heroBgPreview">
                                                    @if(!empty($galleryData['hero']['hero_bg']))
                                                        <img src="{{ asset('assets/gallery/' . $galleryData['hero']['hero_bg']) }}" 
                                                             class="img-fluid rounded" style="max-height: 120px;">
                                                        <div class="mt-1">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="remove_images[hero_bg]" value="1" id="removeHeroBg">
                                                                <label class="form-check-label text-danger small" for="removeHeroBg">Remove</label>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="border rounded p-2 text-center bg-light">
                                                            <i class="fas fa-mountain fa-2x text-muted mb-2"></i>
                                                            <p class="mb-0 text-muted small">No image</p>
                                                        </div>
                                                    @endif
                                                </div>
                                                <input type="file" name="hero_bg_image" class="form-control form-control-sm" id="heroBgInput" accept="image/*">
                                                <input type="hidden" name="current_images[hero_bg]" value="{{ $galleryData['hero']['hero_bg'] ?? '' }}">
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="form-check form-switch mb-2">
                                                <input type="hidden" name="hero[show_stats]" value="0">
                                                <input class="form-check-input" type="checkbox" name="hero[show_stats]" value="1"
                                                    {{ isset($galleryData['hero']['show_stats']) && $galleryData['hero']['show_stats'] == 1 ? 'checked' : '' }}>
                                                <label class="form-check-label small">Show Stats</label>
                                            </div>
                                            <div class="mb-2">
                                                <label class="form-label small fw-bold mb-1">Hero Title</label>
                                                <input type="text" name="hero[title]" class="form-control form-control-sm" value="{{ old('hero.title', $galleryData['hero']['title'] ?? 'My Visual Journey') }}">
                                            </div>
                                        </div>
                                        
                                        <div class="col-12">
                                            <div class="mb-2">
                                                <label class="form-label small fw-bold mb-1">Hero Description</label>
                                                <textarea name="hero[description]" class="form-control form-control-sm" rows="2">{{ old('hero.description', $galleryData['hero']['description'] ?? '') }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            {{-- Layout Settings --}}
                            <div class="card border mb-4">
                                <div class="card-header bg-light py-2">
                                    <h6 class="mb-0"><i class="fas fa-th-large me-2"></i>Layout</h6>
                                </div>
                                <div class="card-body p-3">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-2">
                                                <label class="form-label small fw-bold mb-1">Photos Per Page</label>
                                                <input type="number" name="layout[pictures_per_page]" class="form-control form-control-sm" 
                                                       value="{{ old('layout.pictures_per_page', $galleryData['layout']['pictures_per_page'] ?? 12) }}" min="1" max="48">
                                            </div>
                                            <div class="form-check form-switch mb-2">
                                                <input type="hidden" name="layout[show_sidebar]" value="0">
                                                <input class="form-check-input" type="checkbox" name="layout[show_sidebar]" value="1"
                                                    {{ isset($galleryData['layout']['show_sidebar']) && $galleryData['layout']['show_sidebar'] == 1 ? 'checked' : '' }}>
                                                <label class="form-check-label small">Show Sidebar</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-2">
                                                <label class="form-label small fw-bold mb-1">Grid Columns</label>
                                                <select name="layout[grid_columns]" class="form-select form-select-sm">
                                                    <option value="2" {{ old('layout.grid_columns', $galleryData['layout']['grid_columns'] ?? 3) == 2 ? 'selected' : '' }}>2 Columns</option>
                                                    <option value="3" {{ old('layout.grid_columns', $galleryData['layout']['grid_columns'] ?? 3) == 3 ? 'selected' : '' }}>3 Columns</option>
                                                    <option value="4" {{ old('layout.grid_columns', $galleryData['layout']['grid_columns'] ?? 3) == 4 ? 'selected' : '' }}>4 Columns</option>
                                                </select>
                                            </div>
                                            <div class="form-check form-switch mb-2">
                                                <input type="hidden" name="layout[masonry_enabled]" value="0">
                                                <input class="form-check-input" type="checkbox" name="layout[masonry_enabled]" value="1"
                                                    {{ isset($galleryData['layout']['masonry_enabled']) && $galleryData['layout']['masonry_enabled'] == 1 ? 'checked' : '' }}>
                                                <label class="form-check-label small">Masonry Grid</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            {{-- Sidebar Widgets --}}
                            <div class="card border mb-4">
                                <div class="card-header bg-light py-2">
                                    <h6 class="mb-0"><i class="fas fa-columns me-2"></i>Sidebar Widgets</h6>
                                </div>
                                <div class="card-body p-3">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-check form-switch mb-2">
                                                <input type="hidden" name="sidebar[show_categories_widget]" value="0">
                                                <input class="form-check-input" type="checkbox" name="sidebar[show_categories_widget]" value="1"
                                                    {{ isset($galleryData['sidebar']['show_categories_widget']) && $galleryData['sidebar']['show_categories_widget'] == 1 ? 'checked' : '' }}>
                                                <label class="form-check-label small">Categories</label>
                                            </div>
                                            <div class="form-check form-switch mb-2">
                                                <input type="hidden" name="sidebar[show_recent_photos_widget]" value="0">
                                                <input class="form-check-input" type="checkbox" name="sidebar[show_recent_photos_widget]" value="1"
                                                    {{ isset($galleryData['sidebar']['show_recent_photos_widget']) && $galleryData['sidebar']['show_recent_photos_widget'] == 1 ? 'checked' : '' }}>
                                                <label class="form-check-label small">Recent Photos</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-2">
                                                <label class="form-label small fw-bold mb-1">Recent Photos Title</label>
                                                <input type="text" name="sidebar[recent_photos_title]" class="form-control form-control-sm" 
                                                       value="{{ old('sidebar.recent_photos_title', $galleryData['sidebar']['recent_photos_title'] ?? 'Recent Photos') }}">
                                            </div>
                                            <div class="mb-2">
                                                <label class="form-label small fw-bold mb-1">Photos Count</label>
                                                <input type="number" name="sidebar[recent_photos_count]" class="form-control form-control-sm" 
                                                       value="{{ old('sidebar.recent_photos_count', $galleryData['sidebar']['recent_photos_count'] ?? 8) }}" min="1" max="12">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            {{-- Lightbox Settings --}}
                            <div class="card border mb-4">
                                <div class="card-header bg-light py-2">
                                    <h6 class="mb-0"><i class="fas fa-expand me-2"></i>Lightbox</h6>
                                </div>
                                <div class="card-body p-3">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-check form-switch mb-2">
                                                <input type="hidden" name="lightbox[enabled]" value="0">
                                                <input class="form-check-input" type="checkbox" name="lightbox[enabled]" value="1"
                                                    {{ isset($galleryData['lightbox']['enabled']) && $galleryData['lightbox']['enabled'] == 1 ? 'checked' : '' }}>
                                                <label class="form-check-label small">Enable Lightbox</label>
                                            </div>
                                            <div class="form-check form-switch mb-2">
                                                <input type="hidden" name="lightbox[show_download_button]" value="0">
                                                <input class="form-check-input" type="checkbox" name="lightbox[show_download_button]" value="1"
                                                    {{ isset($galleryData['lightbox']['show_download_button']) && $galleryData['lightbox']['show_download_button'] == 1 ? 'checked' : '' }}>
                                                <label class="form-check-label small">Download Button</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-check form-switch mb-2">
                                                <input type="hidden" name="lightbox[show_fullscreen_button]" value="0">
                                                <input class="form-check-input" type="checkbox" name="lightbox[show_fullscreen_button]" value="1"
                                                    {{ isset($galleryData['lightbox']['show_fullscreen_button']) && $galleryData['lightbox']['show_fullscreen_button'] == 1 ? 'checked' : '' }}>
                                                <label class="form-check-label small">Fullscreen Button</label>
                                            </div>
                                            <div class="form-check form-switch mb-2">
                                                <input type="hidden" name="lightbox[keyboard_navigation]" value="0">
                                                <input class="form-check-input" type="checkbox" name="lightbox[keyboard_navigation]" value="1"
                                                    {{ isset($galleryData['lightbox']['keyboard_navigation']) && $galleryData['lightbox']['keyboard_navigation'] == 1 ? 'checked' : '' }}>
                                                <label class="form-check-label small">Keyboard Nav</label>
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
                                                       value="{{ old('meta.meta_title', $galleryData['meta']['meta_title'] ?? 'My Visual Journey | Photo Gallery') }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-2">
                                                <label class="form-label small fw-bold mb-1">Meta Description</label>
                                                <textarea name="meta[meta_description]" class="form-control form-control-sm" rows="2">{{ old('meta.meta_description', $galleryData['meta']['meta_description'] ?? '') }}</textarea>
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
    
    window.dispatchEvent(new Event('scroll'));
});
</script>
@endsection