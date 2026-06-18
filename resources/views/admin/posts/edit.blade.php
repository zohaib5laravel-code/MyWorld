@extends('admin/app')
@section('content')

<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Edit Post</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{route('posts.index')}}">Posts</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Post</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Edit Post</h5>
                        </div>
                        <form action="{{route('posts.update', $post->id)}}" method="post" enctype="multipart/form-data">
                            @method('put')
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-8">
                                        <div class="row">
                                            <div class="col-lg-12 mb-3">
                                                <label class="form-label" for="title">Title <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="title" id="title" 
                                                       value="{{ old('title', $post->title) }}" required />
                                                @error('title')
                                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-lg-6 mb-3">
                                                <label for="category_id" class="form-label">Category</label>
                                                <select name="category_id" class="form-control">
                                                    <option value="">--Select Category--</option>
                                                    @foreach($categories as $category)
                                                    <option value="{{$category->id}}" {{ old('category_id', $post->category_id) == $category->id ? 'selected' : '' }}>
                                                        {{$category->name}}
                                                    </option>
                                                    @endforeach
                                                </select>
                                                @error('category_id')
                                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-lg-6 mb-3">
                                                <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                                <select name="status" class="form-control" required>
                                                    <option value="draft" {{ old('status', $post->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                                                    <option value="published" {{ old('status', $post->status) == 'published' ? 'selected' : '' }}>Published</option>
                                                    <option value="archived" {{ old('status', $post->status) == 'archived' ? 'selected' : '' }}>Archived</option>
                                                </select>
                                                @error('status')
                                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-lg-12 mb-3">
                                                <label class="form-label" for="excerpt">Excerpt</label>
                                                <textarea class="form-control" name="excerpt" id="excerpt" 
                                                          rows="3" placeholder="Short excerpt of the post">{{ old('excerpt', $post->excerpt) }}</textarea>
                                                <div class="form-text">A brief summary of your post (max 500 characters).</div>
                                                @error('excerpt')
                                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-12 mb-3">
                                                <label class="form-label" for="content">Content <span class="text-danger">*</span></label>
                                                <textarea class="form-control" id="content" name="content" 
                                                          placeholder="Post Content">{{ old('content', $post->content) }}</textarea>
                                                <small class="text-danger ps-2 d-none" id="contentErr">Add content in the body</small>
                                                @error('content')
                                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-lg-6 mb-3">
                                                <label class="form-label" for="featured_image">Featured Image</label>
                                                <input type="file" class="form-control" name="featured_image" 
                                                       id="featuredImageInput" accept="image/*" />
                                                <div class="form-text">Upload a new featured image (JPEG, PNG, GIF, etc.) Max 2MB.</div>
                                                @error('featured_image')
                                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-lg-6 mb-3">
                                                <label class="form-label" for="images">Post Gallery Images</label>
                                                <input type="file" class="form-control" name="images[]" 
                                                       id="galleryImagesInput" accept="image/*" multiple />
                                                <div class="form-text">Add additional images for post gallery (optional).</div>
                                                @error('images')
                                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-lg-6 mb-3">
                                                <label class="form-label" for="published_at">Publish Date/Time</label>
                                                <input type="datetime-local" class="form-control" name="published_at" 
                                                       id="published_at" value="{{ old('published_at', $post->published_at ? date('Y-m-d\TH:i', strtotime($post->published_at)) : '') }}" />
                                                <div class="form-text">Schedule when to publish the post (leave empty for draft/archived).</div>
                                                @error('published_at')
                                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-lg-6 mb-3">
                                                <label class="form-label">Statistics</label>
                                                <div class="form-control bg-light">
                                                    <div class="d-flex justify-content-between">
                                                        <span class="text-muted">Views:</span>
                                                        <span class="fw-bold">{{ $post->views }}</span>
                                                    </div>
                                                    <div class="d-flex justify-content-between">
                                                        <span class="text-muted">Created:</span>
                                                        <span>{{ $post->created_at->format('M d, Y') }}</span>
                                                    </div>
                                                    <div class="d-flex justify-content-between">
                                                        <span class="text-muted">Last Updated:</span>
                                                        <span>{{ $post->updated_at->format('M d, Y') }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Form Inputs Column -->

                                    <!-- Image Preview Column -->
                                    <div class="col-lg-4">
                                        <div class="border rounded p-3 bg-light mb-4">
                                            <h6 class="mb-3 text-center">Featured Image</h6>
                                            <div class="text-center" id="featuredImagePreviewContainer">
                                                @if($post->featured_image)
                                                <img src="{{ asset('assets/posts/' . $post->featured_image) }}"
                                                    id="currentFeaturedImage"
                                                    alt="Current Featured Image"
                                                    class="img-fluid rounded border preview-image"
                                                    style="max-height: 200px;">
                                                <div class="mt-2 text-center text-muted small" id="currentFeaturedFileName">
                                                    {{ $post->featured_image }}
                                                </div>
                                          
                                                @else
                                                <div id="noFeaturedImagePlaceholder">
                                                    <i class="fas fa-image fa-3x text-muted mb-2"></i>
                                                    <p class="text-muted">No featured image</p>
                                                </div>
                                                @endif

                                                <!-- New featured image preview (initially hidden) -->
                                                <div id="newFeaturedImagePreview" class="d-none">
                                                    <img id="previewFeaturedImage"
                                                        src="#"
                                                        alt="New Featured Image Preview"
                                                        class="img-fluid rounded border preview-image"
                                                        style="max-height: 200px;">
                                                    <div class="mt-2 text-center text-muted small" id="newFeaturedFileName"></div>
                                                    <div class="mt-1 text-center">
                                                        <small class="text-info"><i class="fas fa-sync-alt me-1"></i>New selection</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="border rounded p-3 bg-light">
                                            <h6 class="mb-3 text-center">Post Gallery Images</h6>
                                            <div id="galleryPreviewContainer">
                                                @php
                                                    $existingImages = $post->images ? json_decode($post->images, true) : [];
                                                @endphp
                                                
                                                @if(count($existingImages) > 0)
                                                    <div class="mb-3">
                                                        <label class="form-label small">Existing Images:</label>
                                                        <div class="row g-2" id="existingGalleryImages">
                                                            @foreach($existingImages as $index => $image)
                                                            <div class="col-6 col-md-4">
                                                                <div class="gallery-preview-item position-relative">
                                                                    <img src="{{ asset('assets/posts/' . $image) }}" 
                                                                         alt="Gallery Image {{ $index + 1 }}"
                                                                         class="img-fluid rounded border"
                                                                         style="max-height: 80px; object-fit: cover; width: 100%;">
                                                                    <div class="form-check position-absolute top-0 start-0 mt-1 ms-1">
                                                                        <input class="form-check-input" type="checkbox" 
                                                                               name="existing_images[]" 
                                                                               value="{{ $image }}" 
                                                                               id="existingImage{{ $index }}" checked>
                                                                    </div>
                                                                    <div class="small text-truncate mt-1">
                                                                        {{ $image }}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @endforeach
                                                        </div>
                                                        <small class="text-muted">Uncheck images to remove them</small>
                                                    </div>
                                                @else
                                                    <div id="noGalleryImagesPlaceholder" class="text-center">
                                                        <i class="fas fa-images fa-3x text-muted mb-2"></i>
                                                        <p class="text-muted">No gallery images</p>
                                                    </div>
                                                @endif

                                                <div id="newGalleryImagesPreview" class="row g-2 d-none">
                                                </div>
                                            </div>
                                            <div class="mt-3 text-center">
                                                <small class="text-muted" id="galleryCount">
                                                    {{ count($existingImages) }} existing image{{ count($existingImages) != 1 ? 's' : '' }}
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                            
                            <div class="card-footer">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <a href="{{route('posts.index')}}" class="btn btn-outline-secondary me-2">Cancel</a>
                                        <button type="submit" class="btn btn-primary">Update Post</button>
                                    </div>
                                
                                    
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

@endsection

@section('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/35.0.1/classic/ckeditor.js"></script>

<script>
    let editor;

    ClassicEditor
        .create(document.querySelector('#content'))
        .then(ed => {
            editor = ed;

            editor.model.document.on('change:data', () => {
                const contentErr = document.getElementById('contentErr');
                if (editor.getData().trim() !== "") {
                    contentErr.classList.add('d-none');
                }
            });
        })
        .catch(error => console.error(error));

    document.addEventListener('DOMContentLoaded', function() {
        // Featured Image Preview
        const featuredImageInput = document.getElementById('featuredImageInput');
        const previewFeaturedImage = document.getElementById('previewFeaturedImage');
        const newFeaturedImagePreview = document.getElementById('newFeaturedImagePreview');
        const currentFeaturedImage = document.getElementById('currentFeaturedImage');
        const noFeaturedImagePlaceholder = document.getElementById('noFeaturedImagePlaceholder');
        const currentFeaturedFileName = document.getElementById('currentFeaturedFileName');
        const newFeaturedFileName = document.getElementById('newFeaturedFileName');
        const removeFeaturedImageCheckbox = document.getElementById('removeFeaturedImage');

        // Gallery Images Preview
        const galleryImagesInput = document.getElementById('galleryImagesInput');
        const newGalleryImagesPreview = document.getElementById('newGalleryImagesPreview');
        const noGalleryImagesPlaceholder = document.getElementById('noGalleryImagesPlaceholder');
        const galleryCount = document.getElementById('galleryCount');
        const existingGalleryImages = document.getElementById('existingGalleryImages');

        // Featured Image Preview Functionality
        featuredImageInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                // Validate file type
                if (!file.type.match('image.*')) {
                    alert('Please select an image file (JPEG, PNG, GIF, etc.)');
                    this.value = '';
                    return;
                }

                // Validate file size (max 2MB)
                if (file.size > 2 * 1024 * 1024) {
                    alert('Featured image size must be less than 2MB');
                    this.value = '';
                    return;
                }

                const reader = new FileReader();

                reader.addEventListener('load', function() {
                    // Show new image preview
                    previewFeaturedImage.src = reader.result;
                    newFeaturedFileName.textContent = file.name;

                    // Hide current image or placeholder
                    if (currentFeaturedImage) {
                        currentFeaturedImage.style.display = 'none';
                    }
                    if (noFeaturedImagePlaceholder) {
                        noFeaturedImagePlaceholder.style.display = 'none';
                    }
                    if (currentFeaturedFileName) {
                        currentFeaturedFileName.style.display = 'none';
                    }
                    if (removeFeaturedImageCheckbox) {
                        removeFeaturedImageCheckbox.style.display = 'none';
                    }

                    // Show new image preview
                    newFeaturedImagePreview.classList.remove('d-none');

                    // Add animation effect
                    newFeaturedImagePreview.style.opacity = '0';
                    newFeaturedImagePreview.style.transition = 'opacity 0.3s ease';
                    setTimeout(() => {
                        newFeaturedImagePreview.style.opacity = '1';
                    }, 10);
                });

                reader.readAsDataURL(file);
            } else {
                // If no file selected, show the original image again
                newFeaturedImagePreview.classList.add('d-none');
                if (currentFeaturedImage) {
                    currentFeaturedImage.style.display = 'block';
                    currentFeaturedFileName.style.display = 'block';
                    if (removeFeaturedImageCheckbox) {
                        removeFeaturedImageCheckbox.style.display = 'block';
                    }
                }
                if (noFeaturedImagePlaceholder && !currentFeaturedImage) {
                    noFeaturedImagePlaceholder.style.display = 'block';
                }
            }
        });

        // Handle remove featured image checkbox
        if (removeFeaturedImageCheckbox) {
            removeFeaturedImageCheckbox.addEventListener('change', function() {
                if (this.checked) {
                    if (currentFeaturedImage) currentFeaturedImage.style.opacity = '0.5';
                    if (currentFeaturedFileName) currentFeaturedFileName.style.opacity = '0.5';
                    if (featuredImageInput) featuredImageInput.disabled = true;
                } else {
                    if (currentFeaturedImage) currentFeaturedImage.style.opacity = '1';
                    if (currentFeaturedFileName) currentFeaturedFileName.style.opacity = '1';
                    if (featuredImageInput) featuredImageInput.disabled = false;
                }
            });
        }

        // Gallery Images Preview Functionality
        galleryImagesInput.addEventListener('change', function() {
            handleNewGalleryImagesPreview(this.files);
        });

        function handleNewGalleryImagesPreview(files) {
            if (files && files.length > 0) {
                // Clear previous new previews
                newGalleryImagesPreview.innerHTML = '';
                
                // Validate each file
                const validFiles = [];
                for (let i = 0; i < files.length; i++) {
                    const file = files[i];
                    
                    if (!file.type.match('image.*')) {
                        alert(`File "${file.name}" is not an image. Only image files are allowed.`);
                        continue;
                    }
                    
                    if (file.size > 5 * 1024 * 1024) {
                        alert(`File "${file.name}" is too large. Max size is 5MB.`);
                        continue;
                    }
                    
                    validFiles.push(file);
                }
                
                if (validFiles.length === 0) {
                    galleryImagesInput.value = '';
                    newGalleryImagesPreview.classList.add('d-none');
                    return;
                }

                // Show new gallery previews section
                newGalleryImagesPreview.classList.remove('d-none');

                // Process each valid file
                validFiles.forEach((file, index) => {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        // Create preview element
                        const col = document.createElement('div');
                        col.className = 'col-6 col-md-4';
                        
                        const previewDiv = document.createElement('div');
                        previewDiv.className = 'gallery-preview-item position-relative';
                        
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.className = 'img-fluid rounded border';
                        img.style.maxHeight = '80px';
                        img.style.objectFit = 'cover';
                        img.style.width = '100%';
                        
                        const removeBtn = document.createElement('button');
                        removeBtn.type = 'button';
                        removeBtn.className = 'btn btn-sm btn-danger position-absolute top-0 end-0';
                        removeBtn.style.transform = 'translate(30%, -30%)';
                        removeBtn.innerHTML = '<i class="fas fa-times"></i>';
                        removeBtn.onclick = function() {
                            removeNewGalleryImage(index);
                        };
                        
                        const fileName = document.createElement('div');
                        fileName.className = 'small text-truncate mt-1';
                        fileName.textContent = file.name.length > 15 ? file.name.substring(0, 15) + '...' : file.name;
                        
                        previewDiv.appendChild(img);
                        previewDiv.appendChild(removeBtn);
                        previewDiv.appendChild(fileName);
                        col.appendChild(previewDiv);
                        newGalleryImagesPreview.appendChild(col);
                    };

                    reader.readAsDataURL(file);
                });

                // Update count
                updateGalleryCount();
            } else {
                // If no files selected, hide new previews
                newGalleryImagesPreview.classList.add('d-none');
                updateGalleryCount();
            }
        }

        function removeNewGalleryImage(index) {
            const dt = new DataTransfer();
            const files = galleryImagesInput.files;
            
            // Create new file list without the removed file
            for (let i = 0; i < files.length; i++) {
                if (i !== index) {
                    dt.items.add(files[i]);
                }
            }
            
            // Update the input files
            galleryImagesInput.files = dt.files;
            
            // Re-render the preview
            handleNewGalleryImagesPreview(galleryImagesInput.files);
        }

        function updateGalleryCount() {
            let count = 0;
            
            // Count existing checked images
            if (existingGalleryImages) {
                const checkboxes = existingGalleryImages.querySelectorAll('input[type="checkbox"]:checked');
                count += checkboxes.length;
            }
            
            // Count new images
            if (galleryImagesInput.files) {
                count += galleryImagesInput.files.length;
            }
            
            galleryCount.textContent = `${count} total image${count !== 1 ? 's' : ''}`;
        }

        // Update count when existing images are checked/unchecked
        if (existingGalleryImages) {
            existingGalleryImages.addEventListener('change', function(e) {
                if (e.target.type === 'checkbox') {
                    updateGalleryCount();
                }
            });
        }

        // Drag and drop functionality for featured image
        const featuredImagePreviewContainer = document.getElementById('featuredImagePreviewContainer');
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            featuredImagePreviewContainer.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        ['dragenter', 'dragover'].forEach(eventName => {
            featuredImagePreviewContainer.addEventListener(eventName, highlightFeatured, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            featuredImagePreviewContainer.addEventListener(eventName, unhighlightFeatured, false);
        });

        function highlightFeatured(e) {
            featuredImagePreviewContainer.classList.add('border-primary');
            featuredImagePreviewContainer.classList.add('bg-primary-light');
        }

        function unhighlightFeatured(e) {
            featuredImagePreviewContainer.classList.remove('border-primary');
            featuredImagePreviewContainer.classList.remove('bg-primary-light');
        }

        featuredImagePreviewContainer.addEventListener('drop', function(e) {
            const dt = e.dataTransfer;
            const files = dt.files;

            if (files.length > 0) {
                featuredImageInput.files = files;

                // Trigger change event manually
                const event = new Event('change', {
                    bubbles: true
                });
                featuredImageInput.dispatchEvent(event);
            }
        });

        // Format datetime-local input value
        const publishedAtInput = document.getElementById('published_at');
        if (publishedAtInput && !publishedAtInput.value) {
            const now = new Date();
            const timezoneOffset = now.getTimezoneOffset() * 60000;
            const localISOTime = new Date(now - timezoneOffset).toISOString().slice(0, 16);
            publishedAtInput.value = localISOTime;
        }
    });
</script>

<style>
    .bg-primary-light {
        background-color: rgba(13, 110, 253, 0.1) !important;
    }

    .preview-image {
        object-fit: contain;
        max-width: 100%;
        transition: transform 0.3s ease;
    }

    .preview-image:hover {
        transform: scale(1.02);
    }

    #noFeaturedImagePlaceholder,
    #noGalleryImagesPlaceholder {
        transition: all 0.3s ease;
    }

    .gallery-preview-item {
        margin-bottom: 10px;
        position: relative;
    }

    .gallery-preview-item img {
        transition: transform 0.2s ease;
    }

    .gallery-preview-item:hover img {
        transform: scale(1.05);
    }

    .gallery-preview-item button {
        opacity: 0;
        transition: opacity 0.2s ease;
        z-index: 2;
    }

    .gallery-preview-item:hover button {
        opacity: 1;
    }

    .gallery-preview-item .form-check-input {
        opacity: 0;
        transition: opacity 0.2s ease;
        z-index: 2;
    }

    .gallery-preview-item:hover .form-check-input {
        opacity: 1;
    }
</style>
@endsection