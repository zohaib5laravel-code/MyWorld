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
                    <h3 class="mb-0">Add Category</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{route('categories.index')}}">Categories</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Add Category</li>
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
                            <h5 class="card-title mb-0">Add New Category</h5>
                        </div>
                        <!--end::Card Header-->

                        <!--begin::Form-->
                        <form action="{{route('categories.store')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <!--begin::Card Body-->
                            <div class="card-body">
                                <div class="row">
                                    <!-- Form Inputs Column -->
                                    <div class="col-lg-8">
                                        <div class="row">
                                            <div class="col-lg-12 mb-3">
                                                <label for="type" class="form-label">Name <span class="text-danger">*</span></label>
                                                 <input type="text" class="form-control" name="name" id="name" />
                                            </div>

                                            <div class="col-lg-12 mb-3">
                                                <label class="form-label" for="image">Image <span class="text-danger">*</span></label>
                                                <input type="file" class="form-control" name="image" id="imageInput" accept="image/*" required />
                                                <div class="form-text">Upload an image file (JPEG, PNG, GIF, etc.) Max 5MB.</div>
                                            </div>

                                           
                                        </div>
                                    </div>
                                    <!-- End Form Inputs Column -->

                                    <!-- Image Preview Column -->
                                    <div class="col-lg-4">
                                        <div class="border rounded p-3 bg-light">
                                            <h6 class="mb-3 text-center">Image Preview</h6>
                                            <div class="text-center" id="imagePreviewContainer">
                                                <!-- Default placeholder when no image is selected -->
                                                <div id="noImagePlaceholder">
                                                    <i class="fas fa-image fa-3x text-muted mb-2"></i>
                                                    <p class="text-muted">No image selected</p>
                                                    <p class="text-muted small">Select an image to preview</p>
                                                </div>
                                                
                                                <!-- Image preview (initially hidden) -->
                                                <div id="imagePreview" class="d-none">
                                                    <img id="previewImage" 
                                                         src="#" 
                                                         alt="Image Preview" 
                                                         class="img-fluid rounded border preview-image"
                                                         style="max-height: 200px;">
                                                    <div class="mt-2 text-center text-muted small" id="fileName"></div>
                                                    <div class="mt-2">
                                                        <small class="text-success"><i class="fas fa-check-circle me-1"></i>Ready to upload</small>
                                                    </div>
                                                </div>
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
                                    <a href="{{route('categories.index')}}" class="btn btn-outline-secondary me-2">Cancel</a>
                                    <button type="submit" class="btn btn-primary">Add Category</button>
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
<script>
document.addEventListener('DOMContentLoaded', function() {
    const imageInput = document.getElementById('imageInput');
    const previewImage = document.getElementById('previewImage');
    const imagePreview = document.getElementById('imagePreview');
    const noImagePlaceholder = document.getElementById('noImagePlaceholder');
    const fileName = document.getElementById('fileName');
    const previewContainer = document.getElementById('imagePreviewContainer');
    
    // Preview image when file is selected
    imageInput.addEventListener('change', function() {
        const file = this.files[0];
        
        if (file) {
            // Validate file type
            if (!file.type.match('image.*')) {
                alert('Please select an image file (JPEG, PNG, GIF, etc.)');
                this.value = '';
                return;
            }
            
            // Validate file size (max 5MB)
            if (file.size > 5 * 1024 * 1024) {
                alert('File size must be less than 5MB');
                this.value = '';
                return;
            }
            
            const reader = new FileReader();
            
            reader.addEventListener('load', function() {
                // Update preview image
                previewImage.src = reader.result;
                fileName.textContent = file.name;
                
                // Calculate and display image dimensions
                const img = new Image();
                img.onload = function() {
                    const dimensionsText = `${this.width} × ${this.height} pixels`;
                    const sizeText = formatFileSize(file.size);
                    fileName.innerHTML = `${file.name}<br><small class="text-muted">${dimensionsText} • ${sizeText}</small>`;
                };
                img.src = reader.result;
                
                // Hide placeholder and show preview
                noImagePlaceholder.style.display = 'none';
                imagePreview.classList.remove('d-none');
                
                // Add animation effect
                imagePreview.style.opacity = '0';
                imagePreview.style.transition = 'opacity 0.3s ease';
                setTimeout(() => {
                    imagePreview.style.opacity = '1';
                }, 10);
            });
            
            reader.readAsDataURL(file);
        } else {
            // If no file selected, show the placeholder again
            imagePreview.classList.add('d-none');
            noImagePlaceholder.style.display = 'block';
        }
    });
    
    // Helper function to format file size
    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }
    
    // Drag and drop functionality
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        previewContainer.addEventListener(eventName, preventDefaults, false);
    });
    
    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }
    
    ['dragenter', 'dragover'].forEach(eventName => {
        previewContainer.addEventListener(eventName, highlight, false);
    });
    
    ['dragleave', 'drop'].forEach(eventName => {
        previewContainer.addEventListener(eventName, unhighlight, false);
    });
    
    function highlight(e) {
        previewContainer.classList.add('border-primary');
        previewContainer.classList.add('bg-primary-light');
        noImagePlaceholder.innerHTML = '<i class="fas fa-cloud-upload-alt fa-3x text-primary mb-2"></i><p class="text-primary">Drop image here</p>';
    }
    
    function unhighlight(e) {
        previewContainer.classList.remove('border-primary');
        previewContainer.classList.remove('bg-primary-light');
        noImagePlaceholder.innerHTML = '<i class="fas fa-image fa-3x text-muted mb-2"></i><p class="text-muted">No image selected</p><p class="text-muted small">Select an image to preview</p>';
    }
    
    previewContainer.addEventListener('drop', function(e) {
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
            imageInput.files = dataTransfer.files;
            
            // Trigger change event manually
            const event = new Event('change', { bubbles: true });
            imageInput.dispatchEvent(event);
        }
    });
    
    // Optional: Click on preview to trigger file input
    previewContainer.addEventListener('click', function(e) {
        if (e.target === previewContainer || e.target === noImagePlaceholder || 
            e.target.closest('#noImagePlaceholder')) {
            imageInput.click();
        }
    });
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
#imagePreviewContainer {
    cursor: pointer;
    min-height: 250px;
    display: flex;
    align-items: center;
    justify-content: center;
}
#noImagePlaceholder {
    transition: all 0.3s ease;
}
</style>
@endsection