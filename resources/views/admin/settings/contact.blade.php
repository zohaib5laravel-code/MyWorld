@extends('admin.app')

@section('content')
<main class="app-main">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-gradient-primary py-3">
                        <h4 class="mb-0"><i class="fas fa-envelope me-2"></i>Contact Page Settings</h4>
                        <small class="opacity-75">Customize your contact page content and layout</small>
                    </div>
                    
                    <form action="{{ route('settings.contact.update') }}" method="POST" id="contactForm" enctype="multipart/form-data">
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
                                                    @if(!empty($contactData['hero']['hero_bg']))
                                                        <img src="{{ asset('assets/contact/' . $contactData['hero']['hero_bg']) }}" 
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
                                                <input type="hidden" name="current_images[hero_bg]" value="{{ $contactData['hero']['hero_bg'] ?? '' }}">
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="mb-2">
                                                <label class="form-label small fw-bold mb-1">Hero Title</label>
                                                <input type="text" name="hero[title]" class="form-control form-control-sm" 
                                                       value="{{ old('hero.title', $contactData['hero']['title'] ?? "Let's Connect") }}" required>
                                            </div>
                                            <div class="mb-2">
                                                <label class="form-label small fw-bold mb-1">Response Time Note</label>
                                                <input type="text" name="hero[response_time]" class="form-control form-control-sm" 
                                                       value="{{ old('hero.response_time', $contactData['hero']['response_time'] ?? 'I typically respond within 24-48 hours on weekdays.') }}">
                                            </div>
                                        </div>
                                        
                                        <div class="col-12">
                                            <div class="mb-2">
                                                <label class="form-label small fw-bold mb-1">Hero Description</label>
                                                <textarea name="hero[description]" class="form-control form-control-sm" rows="2" required>{{ old('hero.description', $contactData['hero']['description'] ?? '') }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            {{-- Contact Information --}}
                            <div class="card border mb-4">
                                <div class="card-header bg-light py-2">
                                    <h6 class="mb-0"><i class="fas fa-address-card me-2"></i>Contact Information</h6>
                                </div>
                                <div class="card-body p-3">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <div class="mb-2">
                                                <label class="form-label small fw-bold mb-1">Email Address</label>
                                                <input type="email" name="contactInfo[email]" class="form-control form-control-sm" 
                                                       value="{{ old('contactInfo.email', $contactData['contactInfo']['email'] ?? 'hello@myworld.com') }}" required>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="mb-2">
                                                <label class="form-label small fw-bold mb-1">Phone Number</label>
                                                <input type="text" name="contactInfo[phone]" class="form-control form-control-sm" 
                                                       value="{{ old('contactInfo.phone', $contactData['contactInfo']['phone'] ?? '+1 (555) 123-4567') }}">
                                            </div>
                                        </div>
                                        
                                        <div class="col-12">
                                            <div class="mb-2">
                                                <label class="form-label small fw-bold mb-1">Address</label>
                                                <textarea name="contactInfo[address]" class="form-control form-control-sm" rows="2">{{ old('contactInfo.address', $contactData['contactInfo']['address'] ?? '') }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            {{-- FAQ Section --}}
                            <div class="card border mb-4">
                                <div class="card-header bg-light py-2">
                                    <h6 class="mb-0"><i class="fas fa-question-circle me-2"></i>FAQ Section</h6>
                                </div>
                                <div class="card-body p-3">
                                    <div class="mb-3">
                                        <label class="form-label small fw-bold mb-1">FAQ Section Title</label>
                                        <input type="text" name="faq[title]" class="form-control form-control-sm" 
                                               value="{{ old('faq.title', $contactData['faq']['title'] ?? 'Frequently Asked Questions') }}">
                                    </div>
                                    
                                    <div id="faqContainer">
                                        @php
                                            $faqs = old('contactInfo.faqs', $contactData['contactInfo']['faqs'] ?? [
                                                [
                                                    'question' => 'How long does it take to get a response?',
                                                    'answer' => 'I typically respond within 24-48 hours on weekdays.'
                                                ],
                                                [
                                                    'question' => 'Do you accept guest posts?',
                                                    'answer' => 'Yes! I welcome guest posts that align with my blog\'s theme.'
                                                ],
                                                [
                                                    'question' => 'Can I use your photos for personal projects?',
                                                    'answer' => 'Most photos are available for personal, non-commercial use with proper attribution.'
                                                ],
                                            ]);
                                        @endphp
                                        @foreach($faqs as $index => $faq)
                                            <div class="faq-item card mb-2" data-index="{{ $index }}">
                                                <div class="card-body p-2">
                                                    <div class="row g-2 align-items-center">
                                                        <div class="col-md-5">
                                                            <input type="text" 
                                                                   name="contactInfo[faqs][{{ $index }}][question]"
                                                                   class="form-control form-control-sm"
                                                                   value="{{ $faq['question'] ?? '' }}"
                                                                   placeholder="Question">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <textarea name="contactInfo[faqs][{{ $index }}][answer]"
                                                                      class="form-control form-control-sm"
                                                                      rows="1"
                                                                      placeholder="Answer">{{ $faq['answer'] ?? '' }}</textarea>
                                                        </div>
                                                        <div class="col-md-1">
                                                            <button type="button" class="btn btn-sm btn-outline-danger remove-faq">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <button type="button" id="addFaq" class="btn btn-sm btn-outline-primary mt-2">
                                        <i class="fas fa-plus me-1"></i> Add FAQ
                                    </button>
                                </div>
                            </div>
                            
                            {{-- Map Section --}}
                            <div class="card border mb-4">
                                <div class="card-header bg-light py-2">
                                    <h6 class="mb-0"><i class="fas fa-map-marked-alt me-2"></i>Map Section</h6>
                                </div>
                                <div class="card-body p-3">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <div class="mb-2">
                                                <label class="form-label small fw-bold mb-1">Map Title</label>
                                                <input type="text" name="map[title]" class="form-control form-control-sm" 
                                                       value="{{ old('map.title', $contactData['map']['title'] ?? 'Find Me Here') }}">
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="mb-2">
                                                <label class="form-label small fw-bold mb-1">Marker Title</label>
                                                <input type="text" name="map[marker_title]" class="form-control form-control-sm" 
                                                       value="{{ old('map.marker_title', $contactData['map']['marker_title'] ?? 'My World Headquarters') }}">
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-4">
                                            <div class="mb-2">
                                                <label class="form-label small fw-bold mb-1">Latitude</label>
                                                <input type="number" step="any" name="map[latitude]" class="form-control form-control-sm" 
                                                       value="{{ old('map.latitude', $contactData['map']['latitude'] ?? '40.7128') }}">
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-4">
                                            <div class="mb-2">
                                                <label class="form-label small fw-bold mb-1">Longitude</label>
                                                <input type="number" step="any" name="map[longitude]" class="form-control form-control-sm" 
                                                       value="{{ old('map.longitude', $contactData['map']['longitude'] ?? '-74.0060') }}">
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-4">
                                            <div class="mb-2">
                                                <label class="form-label small fw-bold mb-1">Zoom Level</label>
                                                <input type="number" min="1" max="18" name="map[zoom]" class="form-control form-control-sm" 
                                                       value="{{ old('map.zoom', $contactData['map']['zoom'] ?? '13') }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            {{-- Form Settings --}}
                            <div class="card border mb-4">
                                <div class="card-header bg-light py-2">
                                    <h6 class="mb-0"><i class="fas fa-paper-plane me-2"></i>Contact Form</h6>
                                </div>
                                <div class="card-body p-3">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <div class="mb-2">
                                                <label class="form-label small fw-bold mb-1">Form Title</label>
                                                <input type="text" name="form[title]" class="form-control form-control-sm" 
                                                       value="{{ old('form.title', $contactData['form']['title'] ?? 'Send Me a Message') }}">
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="mb-2">
                                                <label class="form-label small fw-bold mb-1">Button Text</label>
                                                <input type="text" name="form[button_text]" class="form-control form-control-sm" 
                                                       value="{{ old('form.button_text', $contactData['form']['button_text'] ?? 'Send Message') }}">
                                            </div>
                                        </div>
                                        
                                        <div class="col-12">
                                            <div class="form-check form-switch mb-2">
                                                <input class="form-check-input" type="checkbox" name="form[enable_captcha]" value="1"
                                                    {{ old('form.enable_captcha', $contactData['form']['enable_captcha'] ?? false) ? 'checked' : '' }}>
                                                <label class="form-check-label small">Enable reCAPTCHA</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            {{-- Section Visibility --}}
                           <div class="section-card card border mb-4">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0"><i class="fas fa-eye me-2"></i>Section Visibility</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-check form-switch mb-3">
                                                <input class="form-check-input" 
                                                       type="checkbox" 
                                                       name="settings[show_hero]"
                                                       value="1"
                                                       {{ old('settings.show_hero', $contactData['settings']['show_hero'] ?? true) ? 'checked' : '' }}>
                                                <label class="form-check-label">Show Hero Section</label>
                                            </div>
                                            <div class="form-check form-switch mb-3">
                                                <input class="form-check-input" 
                                                       type="checkbox" 
                                                       name="settings[show_form]"
                                                       value="1"
                                                       {{ old('settings.show_form', $contactData['settings']['show_form'] ?? true) ? 'checked' : '' }}>
                                                <label class="form-check-label">Show Contact Form</label>
                                            </div>
                                            <div class="form-check form-switch mb-3">
                                                <input class="form-check-input" 
                                                       type="checkbox" 
                                                       name="settings[show_contact_info]"
                                                       value="1"
                                                       {{ old('settings.show_contact_info', $contactData['settings']['show_contact_info'] ?? true) ? 'checked' : '' }}>
                                                <label class="form-check-label">Show Contact Info</label>
                                            </div>
                                           <div class="form-check form-switch mb-3">
                                                <input class="form-check-input" 
                                                       type="checkbox" 
                                                       name="settings[show_business_hours]"
                                                       value="1"
                                                       {{ old('settings.show_business_hours', $contactData['settings']['show_business_hours'] ?? true) ? 'checked' : '' }}>
                                                <label class="form-check-label">Show Business Hours</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                          
                                            <div class="form-check form-switch mb-3">
                                                <input class="form-check-input" 
                                                       type="checkbox" 
                                                       name="settings[show_map]"
                                                       value="1"
                                                       {{ old('settings.show_map', $contactData['settings']['show_map'] ?? true) ? 'checked' : '' }}>
                                                <label class="form-check-label">Show Map</label>
                                            </div>
                                            <div class="form-check form-switch mb-3">
                                                <input class="form-check-input" 
                                                       type="checkbox" 
                                                       name="settings[show_faq]"
                                                       value="1"
                                                       {{ old('settings.show_faq', $contactData['settings']['show_faq'] ?? true) ? 'checked' : '' }}>
                                                <label class="form-check-label">Show FAQ Section</label>
                                            </div>
                                            <div class="form-check form-switch mb-3">
                                                <input class="form-check-input" 
                                                       type="checkbox" 
                                                       name="settings[enable_contact_form]"
                                                       value="1"
                                                       {{ old('settings.enable_contact_form', $contactData['settings']['enable_contact_form'] ?? true) ? 'checked' : '' }}>
                                                <label class="form-check-label">Enable Contact Form Submission</label>
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
    
    // FAQ Management
    let faqIndex = {{ count($contactData['contactInfo']['faqs'] ?? []) }};
    document.getElementById('addFaq').addEventListener('click', function() {
        const container = document.getElementById('faqContainer');
        const html = `
            <div class="faq-item card mb-2" data-index="${faqIndex}">
                <div class="card-body p-2">
                    <div class="row g-2 align-items-center">
                        <div class="col-md-5">
                            <input type="text" 
                                   name="contactInfo[faqs][${faqIndex}][question]"
                                   class="form-control form-control-sm"
                                   placeholder="Question">
                        </div>
                        <div class="col-md-6">
                            <textarea name="contactInfo[faqs][${faqIndex}][answer]"
                                      class="form-control form-control-sm"
                                      rows="1"
                                      placeholder="Answer"></textarea>
                        </div>
                        <div class="col-md-1">
                            <button type="button" class="btn btn-sm btn-outline-danger remove-faq">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>`;
        container.insertAdjacentHTML('beforeend', html);
        faqIndex++;
    });
    
    document.getElementById('faqContainer').addEventListener('click', function(e) {
        if (e.target.closest('.remove-faq')) {
            e.target.closest('.faq-item').remove();
        }
    });
    
    window.dispatchEvent(new Event('scroll'));
});
</script>
@endsection