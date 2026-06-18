{{-- resources/views/admin/partials/flash-messages.blade.php --}}
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
        <div class="d-flex align-items-center">
            <div class="alert-icon flex-shrink-0">
                <i class="fas fa-check-circle fa-lg"></i>
            </div>
            <div class="flex-grow-1 ms-3">
                <h6 class="alert-heading mb-1">Success!</h6>
                <p class="mb-0">{{ session('success') }}</p>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
        <div class="d-flex align-items-center">
            <div class="alert-icon flex-shrink-0">
                <i class="fas fa-exclamation-circle fa-lg"></i>
            </div>
            <div class="flex-grow-1 ms-3">
                <h6 class="alert-heading mb-1">Error!</h6>
                <p class="mb-0">{{ session('error') }}</p>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
@endif

@if(session('warning'))
    <div class="alert alert-warning alert-dismissible fade show shadow-sm" role="alert">
        <div class="d-flex align-items-center">
            <div class="alert-icon flex-shrink-0">
                <i class="fas fa-exclamation-triangle fa-lg"></i>
            </div>
            <div class="flex-grow-1 ms-3">
                <h6 class="alert-heading mb-1">Warning!</h6>
                <p class="mb-0">{{ session('warning') }}</p>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
@endif

@if(session('info'))
    <div class="alert alert-info alert-dismissible fade show shadow-sm" role="alert">
        <div class="d-flex align-items-center">
            <div class="alert-icon flex-shrink-0">
                <i class="fas fa-info-circle fa-lg"></i>
            </div>
            <div class="flex-grow-1 ms-3">
                <h6 class="alert-heading mb-1">Information</h6>
                <p class="mb-0">{{ session('info') }}</p>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
        <div class="d-flex align-items-center">
            <div class="alert-icon flex-shrink-0">
                <i class="fas fa-times-circle fa-lg"></i>
            </div>
            <div class="flex-grow-1 ms-3">
                <h6 class="alert-heading mb-2">
                    <i class="fas fa-exclamation-triangle me-1"></i> Please fix the following errors:
                </h6>
                <ul class="mb-0 ps-3">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
@endif