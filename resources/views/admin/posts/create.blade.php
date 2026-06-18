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
                    <h3 class="mb-0">Add Post</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{route('posts.index')}}">Posts</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Add Post</li>
                    </ol>
                </div>
            </div>
            <!--end::Row-->
        </div>
        <!--end::Container-->
    </div>

    <div class="app-content">
        <!--begin::Container-->
        <div class="container-fluid">
            <!--begin::Row-->
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="card card-primary card-outline">
                        <!--begin::Card Header-->
                        <div class="card-header">
                            <h5 class="card-title mb-0">Add New Post</h5>
                        </div>
                        <!--end::Card Header-->

                        <!--begin::Form-->
                        <form action="{{route('posts.store')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <!--begin::Card Body-->
                            <div class="card-body">
                                <div class="row">
                                    <!-- Form Inputs Column -->
                                    <div class="col-lg-8">
                                        <div class="row">
                                            <div class="col-lg-12 mb-3">
                                                <label class="form-label" for="title">Title <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="title" id="title" required 
                                                       value="{{ old('title') }}" />
                                                @error('title')
                                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-lg-6 mb-3">
                                                <label for="category_id" class="form-label">Category</label>
                                                <select name="category_id" class="form-control">
                                                    <option value="">--Select Category--</option>
                                                    @foreach($categories as $category)
                                                    <option value="{{$category->id}}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
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
                                                    <option value="draft" {{ old('status') == 'draft' ? 'selected' : 'selected' }}>Draft</option>
                                                    <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published</option>
                                                    <option value="archived" {{ old('status') == 'archived' ? 'selected' : '' }}>Archived</option>
                                                </select>
                                                @error('status')
                                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-lg-12 mb-3">
                                                <label class="form-label" for="excerpt">Excerpt</label>
                                                <textarea class="form-control" name="excerpt" id="excerpt" 
                                                          rows="3" placeholder="Short excerpt of the post">{{ old('excerpt') }}</textarea>
                                                <div class="form-text">A brief summary of your post (max 500 characters).</div>
                                                @error('excerpt')
                                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-12 mb-3">
                                                <label class="form-label" for="content">Content <span class="text-danger">*</span></label>
                                                <textarea class="form-control" id="content" name="content" 
                                                          placeholder="Post Content">{{ old('content') }}</textarea>
                                                <small class="text-danger ps-2 d-none" id="contentErr">Add content in the body</small>
                                                @error('content')
                                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-lg-6 mb-3">
                                                <label class="form-label" for="featured_image">Featured Image <span class="text-danger">*</span></label>
                                                <input type="file" class="form-control" name="featured_image" 
                                                       id="featuredImageInput" accept="image/*" required />
                                                <div class="form-text">Upload a featured image (JPEG, PNG, GIF, etc.) Max 2MB.</div>
                                                @error('featured_image')
                                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-lg-6 mb-3">
                                                <label class="form-label" for="images">Post Gallery Images</label>
                                                <input type="file" class="form-control" name="images[]" 
                                                       id="galleryImagesInput" accept="image/*" multiple />
                                                <div class="form-text">Upload additional images for post gallery (optional).</div>
                                                @error('images')
                                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-lg-6 mb-3">
                                                <label class="form-label" for="published_at">Publish Date/Time</label>
                                                <input type="datetime-local" class="form-control" name="published_at" 
                                                       id="published_at" value="{{ old('published_at') }}" />
                                                <div class="form-text">Schedule when to publish the post (leave empty for immediate publication).</div>
                                                @error('published_at')
                                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Form Inputs Column -->

                                    <!-- Image Preview Column -->
                                    <div class="col-lg-4">
                                        <div class="border rounded p-3 bg-light mb-4">
                                            <h6 class="mb-3 text-center">Featured Image Preview</h6>
                                            <div class="text-center" id="featuredImagePreviewContainer">
                                                <!-- Default placeholder when no image is selected -->
                                                <div id="noFeaturedImagePlaceholder">
                                                    <i class="fas fa-image fa-3x text-muted mb-2"></i>
                                                    <p class="text-muted">No image selected</p>
                                                    <p class="text-muted small">Select a featured image to preview</p>
                                                </div>

                                                <!-- Image preview (initially hidden) -->
                                                <div id="featuredImagePreview" class="d-none">
                                                    <img id="previewFeaturedImage"
                                                        src="#"
                                                        alt="Featured Image Preview"
                                                        class="img-fluid rounded border preview-image"
                                                        style="max-height: 200px;">
                                                    <div class="mt-2 text-center text-muted small" id="featuredFileName"></div>
                                                    <div class="mt-2">
                                                        <small class="text-success"><i class="fas fa-check-circle me-1"></i>Ready to upload</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="border rounded p-3 bg-light">
                                            <h6 class="mb-3 text-center">Post Gallery Images</h6>
                                            <div id="galleryPreviewContainer">
                                                <div id="noGalleryImagesPlaceholder" class="text-center">
                                                    <i class="fas fa-images fa-3x text-muted mb-2"></i>
                                                    <p class="text-muted">No post gallery images</p>
                                                    <p class="text-muted small">Select multiple images</p>
                                                </div>
                                                <div id="galleryImagesPreview" class="row g-2 d-none">
                                                    <!-- Post Gallery images will be previewed here -->
                                                </div>
                                            </div>
                                            <div class="mt-3 text-center">
                                                <small class="text-muted" id="galleryCount">0 images selected</small>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Image Preview Column -->
                                </div>
                            </div>
                            <!--end::Card Body-->

                            <!--begin::Card Footer-->
                            <div class="card-footer">
                                <div class="d-flex ">
                                    <a href="{{route('posts.index')}}" class="btn btn-outline-secondary me-2">Cancel</a>
                                    <button type="submit" class="btn btn-primary">Add Post</button>
                                </div>
                            </div>
                            <!--end::Card Footer-->
                        </form>
                        <!--end::Form-->
                    </div>
                </div>
            </div>
            <!--end::Row-->
        </div>
        <!--end::Container-->
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
        const featuredImagePreview = document.getElementById('featuredImagePreview');
        const noFeaturedImagePlaceholder = document.getElementById('noFeaturedImagePlaceholder');
        const featuredFileName = document.getElementById('featuredFileName');
        const featuredImagePreviewContainer = document.getElementById('featuredImagePreviewContainer');

        // Gallery Images Preview
        const galleryImagesInput = document.getElementById('galleryImagesInput');
        const galleryImagesPreview = document.getElementById('galleryImagesPreview');
        const noGalleryImagesPlaceholder = document.getElementById('noGalleryImagesPlaceholder');
        const galleryCount = document.getElementById('galleryCount');
        const galleryPreviewContainer = document.getElementById('galleryPreviewContainer');

        // Featured Image Preview Functionality
        featuredImageInput.addEventListener('change', function() {
            handleFeaturedImagePreview(this.files[0]);
        });

        function handleFeaturedImagePreview(file) {
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
                    // Update preview image
                    previewFeaturedImage.src = reader.result;
                    featuredFileName.textContent = file.name;

                    // Calculate and display image dimensions
                    const img = new Image();
                    img.onload = function() {
                        const dimensionsText = `${this.width} × ${this.height} pixels`;
                        const sizeText = formatFileSize(file.size);
                        featuredFileName.innerHTML = `${file.name}<br><small class="text-muted">${dimensionsText} • ${sizeText}</small>`;
                    };
                    img.src = reader.result;

                    // Hide placeholder and show preview
                    noFeaturedImagePlaceholder.style.display = 'none';
                    featuredImagePreview.classList.remove('d-none');

                    // Add animation effect
                    featuredImagePreview.style.opacity = '0';
                    featuredImagePreview.style.transition = 'opacity 0.3s ease';
                    setTimeout(() => {
                        featuredImagePreview.style.opacity = '1';
                    }, 10);
                });

                reader.readAsDataURL(file);
            } else {
                // If no file selected, show the placeholder again
                featuredImagePreview.classList.add('d-none');
                noFeaturedImagePlaceholder.style.display = 'block';
            }
        }

        // Gallery Images Preview Functionality
        galleryImagesInput.addEventListener('change', function() {
            handleGalleryImagesPreview(this.files);
        });

        function handleGalleryImagesPreview(files) {
            if (files && files.length > 0) {
                // Clear previous preview
                galleryImagesPreview.innerHTML = '';
                
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
                    galleryImagesPreview.classList.add('d-none');
                    noGalleryImagesPlaceholder.classList.remove('d-none');
                    galleryCount.textContent = '0 images selected';
                    return;
                }

                // Update count
                galleryCount.textContent = `${validFiles.length} image${validFiles.length > 1 ? 's' : ''} selected`;

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
                            removeGalleryImage(index);
                        };
                        
                        const fileName = document.createElement('div');
                        fileName.className = 'small text-truncate mt-1';
                        fileName.textContent = file.name.length > 15 ? file.name.substring(0, 15) + '...' : file.name;
                        
                        previewDiv.appendChild(img);
                        previewDiv.appendChild(removeBtn);
                        previewDiv.appendChild(fileName);
                        col.appendChild(previewDiv);
                        galleryImagesPreview.appendChild(col);
                    };

                    reader.readAsDataURL(file);
                });

                // Show preview and hide placeholder
                galleryImagesPreview.classList.remove('d-none');
                noGalleryImagesPlaceholder.classList.add('d-none');
            } else {
                // If no files selected, show the placeholder again
                galleryImagesPreview.classList.add('d-none');
                noGalleryImagesPlaceholder.classList.remove('d-none');
                galleryCount.textContent = '0 images selected';
            }
        }

        function removeGalleryImage(index) {
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
            handleGalleryImagesPreview(galleryImagesInput.files);
        }

        // Helper function to format file size
        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        }

        // Drag and drop functionality for featured image
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
            noFeaturedImagePlaceholder.innerHTML = '<i class="fas fa-cloud-upload-alt fa-3x text-primary mb-2"></i><p class="text-primary">Drop image here</p>';
        }

        function unhighlightFeatured(e) {
            featuredImagePreviewContainer.classList.remove('border-primary');
            featuredImagePreviewContainer.classList.remove('bg-primary-light');
            noFeaturedImagePlaceholder.innerHTML = '<i class="fas fa-image fa-3x text-muted mb-2"></i><p class="text-muted">No image selected</p><p class="text-muted small">Select an image to preview</p>';
        }

        featuredImagePreviewContainer.addEventListener('drop', function(e) {
            const dt = e.dataTransfer;
            const files = dt.files;

            if (files.length > 0) {
                const file = files[0];

                // Validate it's an image
                if (!file.type.match('image.*')) {
                    alert('Please drop an image file (JPEG, PNG, GIF, etc.)');
                    return;
                }

                // Set the file to the input
                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(file);
                featuredImageInput.files = dataTransfer.files;

                // Trigger preview manually
                handleFeaturedImagePreview(file);
            }
        });

        // Optional: Click on preview to trigger file input
        featuredImagePreviewContainer.addEventListener('click', function(e) {
            if (e.target === featuredImagePreviewContainer || e.target === noFeaturedImagePlaceholder ||
                e.target.closest('#noFeaturedImagePlaceholder')) {
                featuredImageInput.click();
            }
        });

        // Set default publish date/time to now
        const now = new Date();
        const timezoneOffset = now.getTimezoneOffset() * 60000; // Offset in milliseconds
        const localISOTime = new Date(now - timezoneOffset).toISOString().slice(0, 16);
        if (!document.getElementById('published_at').value) {
            document.getElementById('published_at').value = localISOTime;
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

    #featuredImagePreviewContainer,
    #galleryPreviewContainer {
        cursor: pointer;
        min-height: 200px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    #noFeaturedImagePlaceholder,
    #noGalleryImagesPlaceholder {
        transition: all 0.3s ease;
    }

    .gallery-preview-item {
        margin-bottom: 10px;
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
    }

    .gallery-preview-item:hover button {
        opacity: 1;
    }
</style>
@endsection