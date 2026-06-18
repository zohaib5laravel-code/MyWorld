@extends('admin.app')

@section('content')
<main class="app-main">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-gradient-primary py-3">
                        <h4 class="mb-0"><i class="fas fa-user-circle me-2"></i>About Page Settings</h4>
                        <small class="opacity-75">Customize your about page content and layout</small>
                    </div>
                    
                    <form action="{{ route('settings.about.update') }}" method="POST" id="aboutForm" enctype="multipart/form-data">
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
                                    <h6 class="mb-0"><i class="fas fa-images me-2"></i>Hero Section</h6>
                                </div>
                                <div class="card-body p-3">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label small fw-bold mb-1">Hero Background</label>
                                            <div class="image-upload-wrapper">
                                                <div class="image-preview mb-2" id="heroBgPreview">
                                                    @if(!empty($aboutData['images']['hero_bg']))
                                                        <img src="{{ asset('assets/about/' . $aboutData['images']['hero_bg']) }}" 
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
                                                <input type="hidden" name="current_images[hero_bg]" value="{{ $aboutData['images']['hero_bg'] ?? '' }}">
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <label class="form-label small fw-bold mb-1">Profile Image</label>
                                            <div class="image-upload-wrapper">
                                                <div class="image-preview mb-2" id="profileImagePreview">
                                                    @if(!empty($aboutData['images']['profile']))
                                                        <img src="{{ asset('assets/about/' . $aboutData['images']['profile']) }}" 
                                                             class="img-fluid rounded-circle" style="width: 120px; height: 120px; object-fit: cover;">
                                                        <div class="mt-1">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="remove_images[profile]" value="1" id="removeProfile">
                                                                <label class="form-check-label text-danger small" for="removeProfile">Remove</label>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="border rounded p-2 text-center bg-light">
                                                            <i class="fas fa-user-circle fa-2x text-muted mb-2"></i>
                                                            <p class="mb-0 text-muted small">No image</p>
                                                        </div>
                                                    @endif
                                                </div>
                                                <input type="file" name="profile_image" class="form-control form-control-sm" id="profileImageInput" accept="image/*">
                                                <input type="hidden" name="current_images[profile]" value="{{ $aboutData['images']['profile'] ?? '' }}">
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="mb-2">
                                                <label class="form-label small fw-bold mb-1">Hero Text</label>
                                                <textarea name="hero[text]" class="form-control form-control-sm" rows="2">{{ old('hero.text', $aboutData['hero']['text'] ?? 'Welcome to my personal corner of the internet') }}</textarea>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="mb-2">
                                                <label class="form-label small fw-bold mb-1">Button Text</label>
                                                <input type="text" name="hero[button_text]" class="form-control form-control-sm" value="{{ old('hero.button_text', $aboutData['hero']['button_text'] ?? 'My Story') }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            {{-- Personal Info --}}
                            <div class="card border mb-4">
                                <div class="card-header bg-light py-2">
                                    <h6 class="mb-0"><i class="fas fa-user me-2"></i>Personal Information</h6>
                                </div>
                                <div class="card-body p-3">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <div class="mb-2">
                                                <label class="form-label small fw-bold mb-1">Your Name</label>
                                                <input type="text" name="personalInfo[name]" class="form-control form-control-sm" value="{{ old('personalInfo.name', $aboutData['personalInfo']['name'] ?? 'Alex') }}" required>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="mb-2">
                                                <label class="form-label small fw-bold mb-1">Location</label>
                                                <input type="text" name="personalInfo[location]" class="form-control form-control-sm" value="{{ old('personalInfo.location', $aboutData['personalInfo']['location'] ?? 'Somewhere Beautiful') }}">
                                            </div>
                                        </div>
                                        
                                        <div class="col-12">
                                            <div class="mb-2">
                                                <label class="form-label small fw-bold mb-1">Bio/Introduction</label>
                                                <textarea name="personalInfo[bio]" class="form-control form-control-sm" rows="2">{{ old('personalInfo.bio', $aboutData['personalInfo']['bio'] ?? '') }}</textarea>
                                            </div>
                                        </div>
                                        
                                        <div class="col-12">
                                            <label class="form-label small fw-bold mb-1">Interests</label>
                                            <div class="row" id="interestsContainer">
                                                @php
                                                    $interests = old('personalInfo.interests', $aboutData['personalInfo']['interests'] ?? ['Photography', 'Writing', 'Hiking', 'Coffee Brewing', 'Reading', 'Stargazing']);
                                                @endphp
                                                @foreach($interests as $index => $interest)
                                                    <div class="col-lg-4 d-flex mb-2 interest-item">
                                                        <input type="text" 
                                                               name="personalInfo[interests][{{ $index }}]"
                                                               class="form-control form-control-sm"
                                                               value="{{ $interest }}">
                                                        <button type="button" class="btn btn-sm btn-outline-danger remove-interest">
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <button type="button" id="addInterest" class="btn btn-sm btn-outline-primary mt-2">
                                                <i class="fas fa-plus me-1"></i> Add Interest
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            {{-- Core Values --}}
                            <div class="card border mb-4">
                                <div class="card-header bg-light py-2">
                                    <h6 class="mb-0"><i class="fas fa-star me-2"></i>Core Values</h6>
                                </div>
                                <div class="card-body p-3">
                                    <div class="mb-3">
                                        <label class="form-label small fw-bold mb-1">Section Title</label>
                                        <input type="text" name="values[title]" class="form-control form-control-sm" value="{{ old('values.title', $aboutData['values']['title'] ?? 'What Guides My Journey') }}">
                                    </div>
                                    
                                    <div id="valuesContainer">
                                        @php
                                            $values = old('values.items', $aboutData['values']['items'] ?? [
                                                ['icon' => 'fas fa-heart', 'title' => 'Authenticity', 'description' => 'Keeping it real - no filters, no pretenses.'],
                                                ['icon' => 'fas fa-compass', 'title' => 'Curiosity', 'description' => 'Always exploring, always learning.'],
                                                ['icon' => 'fas fa-hands', 'title' => 'Connection', 'description' => 'Building bridges through stories.'],
                                                ['icon' => 'fas fa-sun', 'title' => 'Positivity', 'description' => 'Finding light in challenging moments.']
                                            ]);
                                        @endphp
                                        @foreach($values as $index => $value)
                                            <div class="value-item card mb-2" data-index="{{ $index }}">
                                                <div class="card-body p-2">
                                                    <div class="row g-2 align-items-center">
                                                        <div class="col-md-2">
                                                            <input type="text" 
                                                                   name="values[items][{{ $index }}][icon]"
                                                                   class="form-control form-control-sm"
                                                                   value="{{ $value['icon'] ?? '' }}"
                                                                   placeholder="fas fa-heart">
                                                        </div>
                                                        <div class="col-md-3">
                                                            <input type="text" 
                                                                   name="values[items][{{ $index }}][title]"
                                                                   class="form-control form-control-sm"
                                                                   value="{{ $value['title'] ?? '' }}"
                                                                   placeholder="Authenticity">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <textarea name="values[items][{{ $index }}][description]"
                                                                      class="form-control form-control-sm"
                                                                      rows="1"
                                                                      placeholder="Description">{{ $value['description'] ?? '' }}</textarea>
                                                        </div>
                                                        <div class="col-md-1">
                                                            <button type="button" class="btn btn-sm btn-outline-danger remove-value">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <button type="button" id="addValue" class="btn btn-sm btn-outline-primary mt-2">
                                        <i class="fas fa-plus me-1"></i> Add Value
                                    </button>
                                </div>
                            </div>
                            
                            {{-- Journey Timeline --}}
                            <div class="card border mb-4">
                                <div class="card-header bg-light py-2">
                                    <h6 class="mb-0"><i class="fas fa-road me-2"></i>Journey Timeline</h6>
                                </div>
                                <div class="card-body p-3">
                                    <div class="mb-3">
                                        <label class="form-label small fw-bold mb-1">Section Title</label>
                                        <input type="text" name="journey[title]" class="form-control form-control-sm" value="{{ old('journey.title', $aboutData['journey']['title'] ?? 'My Journey So Far') }}">
                                    </div>
                                    
                                    <div id="journeyContainer">
                                        @php
                                            $journeyItems = old('journey.items', $aboutData['journey']['items'] ?? [
                                                ['year' => '2018', 'title' => 'The First Click', 'description' => 'Started documenting my daily life.'],
                                                ['year' => '2019', 'title' => 'Finding My Voice', 'description' => 'Began writing alongside photos.'],
                                                ['year' => '2020', 'title' => 'Going Digital', 'description' => 'Created My World blog.']
                                            ]);
                                        @endphp
                                        @foreach($journeyItems as $index => $milestone)
                                            <div class="journey-item card mb-2" data-index="{{ $index }}">
                                                <div class="card-body p-2">
                                                    <div class="row g-2 align-items-center">
                                                        <div class="col-md-2">
                                                            <input type="text" 
                                                                   name="journey[items][{{ $index }}][year]"
                                                                   class="form-control form-control-sm"
                                                                   value="{{ $milestone['year'] ?? '' }}"
                                                                   placeholder="2020">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <input type="text" 
                                                                   name="journey[items][{{ $index }}][title]"
                                                                   class="form-control form-control-sm"
                                                                   value="{{ $milestone['title'] ?? '' }}"
                                                                   placeholder="First Solo Trip">
                                                        </div>
                                                        <div class="col-md-5">
                                                            <textarea name="journey[items][{{ $index }}][description]"
                                                                      class="form-control form-control-sm"
                                                                      rows="1"
                                                                      placeholder="Description">{{ $milestone['description'] ?? '' }}</textarea>
                                                        </div>
                                                        <div class="col-md-1">
                                                            <button type="button" class="btn btn-sm btn-outline-danger remove-journey">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <button type="button" id="addJourney" class="btn btn-sm btn-outline-primary mt-2">
                                        <i class="fas fa-plus me-1"></i> Add Milestone
                                    </button>
                                </div>
                            </div>
                            
                            {{-- Contact Section --}}
                            <div class="card border mb-4">
                                <div class="card-header bg-light py-2">
                                    <h6 class="mb-0"><i class="fas fa-envelope me-2"></i>Contact Section</h6>
                                </div>
                                <div class="card-body p-3">
                                    <div class="mb-3">
                                        <label class="form-label small fw-bold mb-1">Section Title</label>
                                        <input type="text" name="contact[title]" class="form-control form-control-sm" value="{{ old('contact.title', $aboutData['contact']['title'] ?? "Let's Connect") }}">
                                    </div>
                                    
                                    <div class="row g-2">
                                        <div class="col-md-6">
                                            <div class="mb-2">
                                                <label class="form-label small fw-bold mb-1">Instagram URL</label>
                                                <input type="url" name="contact[social][instagram]" class="form-control form-control-sm" value="{{ old('contact.social.instagram', $aboutData['contact']['social']['instagram'] ?? '#') }}">
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="mb-2">
                                                <label class="form-label small fw-bold mb-1">Twitter URL</label>
                                                <input type="url" name="contact[social][twitter]" class="form-control form-control-sm" value="{{ old('contact.social.twitter', $aboutData['contact']['social']['twitter'] ?? '#') }}">
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="mb-2">
                                                <label class="form-label small fw-bold mb-1">Email Address</label>
                                                <input type="email" name="contact[social][email]" class="form-control form-control-sm" value="{{ old('contact.social.email', $aboutData['contact']['social']['email'] ?? '#') }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            {{-- Section Visibility --}}
                            <div class="card border">
                                <div class="card-header bg-light py-2">
                                    <h6 class="mb-0"><i class="fas fa-eye me-2"></i>Section Visibility</h6>
                                </div>
                                <div class="card-body p-3">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-check form-switch mb-2">
                                                <input class="form-check-input" type="checkbox" name="settings[show_hero_images]" value="1"
                                                    {{ old('settings.show_hero_images', $aboutData['settings']['show_hero_images'] ?? true) ? 'checked' : '' }}>
                                                <label class="form-check-label small">Hero Images</label>
                                            </div>
                                            <div class="form-check form-switch mb-2">
                                                <input class="form-check-input" type="checkbox" name="settings[show_personal_info]" value="1"
                                                    {{ old('settings.show_personal_info', $aboutData['settings']['show_personal_info'] ?? true) ? 'checked' : '' }}>
                                                <label class="form-check-label small">Personal Info</label>
                                            </div>
                                            <div class="form-check form-switch mb-2">
                                                <input class="form-check-input" type="checkbox" name="settings[show_values]" value="1"
                                                    {{ old('settings.show_values', $aboutData['settings']['show_values'] ?? true) ? 'checked' : '' }}>
                                                <label class="form-check-label small">Values</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-check form-switch mb-2">
                                                <input class="form-check-input" type="checkbox" name="settings[show_journey]" value="1"
                                                    {{ old('settings.show_journey', $aboutData['settings']['show_journey'] ?? true) ? 'checked' : '' }}>
                                                <label class="form-check-label small">Journey</label>
                                            </div>
                                            <div class="form-check form-switch mb-2">
                                                <input class="form-check-input" type="checkbox" name="settings[show_contact]" value="1"
                                                    {{ old('settings.show_contact', $aboutData['settings']['show_contact'] ?? true) ? 'checked' : '' }}>
                                                <label class="form-check-label small">Contact</label>
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
    
    // Image preview for profile image
    const profileInput = document.getElementById('profileImageInput');
    const profilePreview = document.getElementById('profileImagePreview');
    
    if (profileInput && profilePreview) {
        profileInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    profilePreview.innerHTML = `
                        <img src="${e.target.result}" class="img-fluid rounded-circle" style="width: 120px; height: 120px; object-fit: cover;">
                        <div class="mt-1">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remove_images[profile]" value="1" id="removeProfile">
                                <label class="form-check-label text-danger small" for="removeProfile">Remove</label>
                            </div>
                        </div>
                    `;
                };
                reader.readAsDataURL(this.files[0]);
            }
        });
    }
    
    // Interests Management
    let interestIndex = {{ count($aboutData['personalInfo']['interests'] ?? []) }};
    document.getElementById('addInterest').addEventListener('click', function() {
        const container = document.getElementById('interestsContainer');
        const html = `
            <div class="col-lg-4 d-flex mb-2 interest-item">
                <input type="text" 
                       name="personalInfo[interests][${interestIndex}]"
                       class="form-control form-control-sm"
                       placeholder="e.g., Photography">
                <button type="button" class="btn btn-sm btn-outline-danger remove-interest">
                    <i class="fas fa-times"></i>
                </button>
            </div>`;
        container.insertAdjacentHTML('beforeend', html);
        interestIndex++;
    });
    
    document.getElementById('interestsContainer').addEventListener('click', function(e) {
        if (e.target.closest('.remove-interest')) {
            e.target.closest('.interest-item').remove();
        }
    });
    
    // Values Management
    let valueIndex = {{ count($aboutData['values']['items'] ?? []) }};
    document.getElementById('addValue').addEventListener('click', function() {
        const container = document.getElementById('valuesContainer');
        const html = `
            <div class="value-item card mb-2" data-index="${valueIndex}">
                <div class="card-body p-2">
                    <div class="row g-2 align-items-center">
                        <div class="col-md-2">
                            <input type="text" 
                                   name="values[items][${valueIndex}][icon]"
                                   class="form-control form-control-sm"
                                   placeholder="fas fa-heart">
                        </div>
                        <div class="col-md-3">
                            <input type="text" 
                                   name="values[items][${valueIndex}][title]"
                                   class="form-control form-control-sm"
                                   placeholder="Authenticity">
                        </div>
                        <div class="col-md-6">
                            <textarea name="values[items][${valueIndex}][description]"
                                      class="form-control form-control-sm"
                                      rows="1"
                                      placeholder="Description"></textarea>
                        </div>
                        <div class="col-md-1">
                            <button type="button" class="btn btn-sm btn-outline-danger remove-value">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>`;
        container.insertAdjacentHTML('beforeend', html);
        valueIndex++;
    });
    
    document.getElementById('valuesContainer').addEventListener('click', function(e) {
        if (e.target.closest('.remove-value')) {
            e.target.closest('.value-item').remove();
        }
    });
    
    // Journey Management
    let journeyIndex = {{ count($aboutData['journey']['items'] ?? []) }};
    document.getElementById('addJourney').addEventListener('click', function() {
        const container = document.getElementById('journeyContainer');
        const html = `
            <div class="journey-item card mb-2" data-index="${journeyIndex}">
                <div class="card-body p-2">
                    <div class="row g-2 align-items-center">
                        <div class="col-md-2">
                            <input type="text" 
                                   name="journey[items][${journeyIndex}][year]"
                                   class="form-control form-control-sm"
                                   placeholder="2020">
                        </div>
                        <div class="col-md-4">
                            <input type="text" 
                                   name="journey[items][${journeyIndex}][title]"
                                   class="form-control form-control-sm"
                                   placeholder="First Solo Trip">
                        </div>
                        <div class="col-md-5">
                            <textarea name="journey[items][${journeyIndex}][description]"
                                      class="form-control form-control-sm"
                                      rows="1"
                                      placeholder="Description"></textarea>
                        </div>
                        <div class="col-md-1">
                            <button type="button" class="btn btn-sm btn-outline-danger remove-journey">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>`;
        container.insertAdjacentHTML('beforeend', html);
        journeyIndex++;
    });
    
    document.getElementById('journeyContainer').addEventListener('click', function(e) {
        if (e.target.closest('.remove-journey')) {
            e.target.closest('.journey-item').remove();
        }
    });
    
 
    
    // Initialize
    window.dispatchEvent(new Event('scroll'));
});
</script>
@endsection