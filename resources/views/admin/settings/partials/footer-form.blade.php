<form action="{{ route('settings.footer.update') }}" method="POST" id="footerForm" class="h-100 d-flex flex-column">
    @csrf
    
    <div class="card-body flex-grow-1 overflow-auto section-content">
        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show">
                <h5 class="alert-heading"><i class="bi bi-exclamation-triangle me-2"></i>Validation Errors</h5>
                <ul class="mb-0 ps-3">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row g-4">
            {{-- Status --}}
            <div class="col-md-12 col-lg-6">
                <div class="settings-card card border h-100">
                    <div class="card-header bg-light">
                        <h6 class="mb-0"><i class="bi bi-toggle-on me-2"></i>About</h6>
                    </div>
                    <div class="card-body">
                      <div class="d-flex justify-content-between">
                          <div class="mb-3 col-lg-5">
                            <label class="form-label">Footer Status</label>
                            <select name="status" class="form-select" required>
                                <option value="1" {{ $status ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ !$status ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                          <div class="mb-3 col-lg-6">
                            <label class="form-label">Title</label>
                            <input type="text" name="footer[about][title]" 
                                   class="form-control form-control-sm" 
                                   placeholder="e.g., My Company"
                                   value="{{ old('footer.about.title', $footer['about']['title'] ?? '') }}">
                        </div>
                      </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="footer[about][description]" 
                                      class="form-control form-control-sm" 
                                      rows="2"
                                      placeholder="Brief description about your company">{{ old('footer.about.description', $footer['about']['description'] ?? '') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ABOUT SECTION --}}
            <div class="col-md-6 col-lg-3">
                <div class="settings-card card border h-100" data-section="about">
                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                        <h6 class="mb-0"><i class="bi bi-info-circle me-2"></i>Social Links</h6>
                        
                    </div>
                    <div class="card-body section-content">
                      
                        
                        <div class="mb-0">
                            <label class="form-label mb-2"> Links</label>
                            <div class="social-inputs">
                                @foreach($social_platforms as $platform)
                                    <div class="input-group input-group-sm mb-2">
                                        <span class="input-group-text bg-light">
                                            <i class="bi bi-{{ $platform }} text-primary"></i>
                                        </span>
                                        <input type="text" 
                                               name="footer[about][social][{{ $platform }}]"
                                               class="form-control"
                                               placeholder="{{ ucfirst($platform) }} URL"
                                               value="{{ old("footer.about.social.$platform", $footer['about']['social'][$platform] ?? '') }}">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- QUICK LINKS --}}
            <div class="col-md-6 col-lg-3">
                <div class="settings-card card border h-100" data-section="quick-links">
                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                        <h6 class="mb-0"><i class="bi bi-link-45deg me-2"></i>Quick Links</h6>
                        
                    </div>
                    <div class="card-body section-content">
                        <div class="mb-3">
                            <label class="form-label mb-2">Links</label>
                            <div id="quickLinksContainer" class="mb-3">
                                @foreach(old('footer.quick_links', $footer['quick_links'] ?? []) as $index => $link)
                                    <div class="link-item mb-2" data-index="{{ $index }}">
                                        <div class="d-flex gap-2 align-items-start">
                                            <div class="flex-grow-1">
                                                <div class="row g-1">
                                                    <div class="col-6">
                                                        <input type="text" 
                                                               name="footer[quick_links][{{ $index }}][label]"
                                                               class="form-control form-control-sm"
                                                               placeholder="Label"
                                                               value="{{ $link['label'] ?? '' }}"
                                                               required>
                                                    </div>
                                                    <div class="col-6">
                                                        <input type="text" 
                                                               name="footer[quick_links][{{ $index }}][url]"
                                                               class="form-control form-control-sm"
                                                               placeholder="URL"
                                                               value="{{ $link['url'] ?? '' }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <button type="button" class="btn btn-sm btn-outline-danger remove-link">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            
                            <button type="button" id="addQuickLink" class="btn btn-sm btn-outline-primary w-100">
                                <i class="bi bi-plus-circle me-1"></i> Add Link
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- CONTACT INFO --}}
            <div class="col-md-6 col-lg-3">
                <div class="settings-card card border h-100" data-section="contact">
                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                        <h6 class="mb-0"><i class="bi bi-envelope-paper me-2"></i>Contact</h6>
                        
                    </div>
                    <div class="card-body section-content">
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" 
                                   name="footer[contact][email]"
                                   class="form-control form-control-sm"
                                   placeholder="contact@example.com"
                                   value="{{ old('footer.contact.email', $footer['contact']['email'] ?? '') }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Phone</label>
                            <input type="text" 
                                   name="footer[contact][phone]"
                                   class="form-control form-control-sm"
                                   placeholder="+1 (555) 123-4567"
                                   value="{{ old('footer.contact.phone', $footer['contact']['phone'] ?? '') }}">
                        </div>
                        <div class="mb-0">
                            <label class="form-label">Address</label>
                            <textarea name="footer[contact][address]"
                                      class="form-control form-control-sm"
                                      rows="2"
                                      placeholder="Full address">{{ old('footer.contact.address', $footer['contact']['address'] ?? '') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            {{-- NEWSLETTER --}}
            <div class="col-md-6 col-lg-3">
                <div class="settings-card card border h-100" data-section="newsletter">
                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                        <h6 class="mb-0"><i class="bi bi-megaphone me-2"></i>Newsletter</h6>
                        <div class="form-check form-switch">
                            <input class="form-check-input section-toggle" 
                                   type="checkbox" 
                                   name="footer[newsletter][enabled]"
                                   value="1"
                                   {{ old('footer.newsletter.enabled', $footer['newsletter']['enabled'] ?? false) ? 'checked' : '' }}>
                        </div>
                    </div>
                    <div class="card-body section-content">
                        <div class="mb-3">
                            <label class="form-label">Placeholder Text</label>
                            <input type="text" 
                                   name="footer[newsletter][placeholder]"
                                   class="form-control form-control-sm"
                                   placeholder="e.g., Enter your email"
                                   value="{{ old('footer.newsletter.placeholder', $footer['newsletter']['placeholder'] ?? '') }}">
                        </div>
                        <div class="mb-0">
                            <label class="form-label">Button Text</label>
                            <input type="text" 
                                   name="footer[newsletter][button_text]"
                                   class="form-control form-control-sm"
                                   placeholder="e.g., Subscribe"
                                   value="{{ old('footer.newsletter.button_text', $footer['newsletter']['button_text'] ?? '') }}">
                        </div>
                    </div>
                </div>
            </div>

            {{-- STYLING --}}
            <div class="col-md-6 col-lg-3">
                <div class="settings-card card border h-100" data-section="style">
                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                        <h6 class="mb-0"><i class="bi bi-palette me-2"></i>Styling</h6>
                        
                    </div>
                    <div class="card-body section-content">
                        <div class="mb-3">
                            <label class="form-label small">Background</label>
                            <input type="text" 
                                   name="footer[style][bg_class]"
                                   class="form-control form-control-sm"
                                   placeholder="bg-dark, bg-primary, etc."
                                   value="{{ old('footer.style.bg_class', $footer['style']['bg_class'] ?? 'bg-dark') }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label small">Text Color</label>
                            <input type="text" 
                                   name="footer[style][text_class]"
                                   class="form-control form-control-sm"
                                   placeholder="text-light, text-white, etc."
                                   value="{{ old('footer.style.text_class', $footer['style']['text_class'] ?? 'text-light') }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label small">Link Style</label>
                            <input type="text" 
                                   name="footer[style][link_class]"
                                   class="form-control form-control-sm"
                                   placeholder="Link classes"
                                   value="{{ old('footer.style.link_class', $footer['style']['link_class'] ?? 'text-light text-decoration-none') }}">
                        </div>
                        <div class="mb-0">
                            <label class="form-label small">Icon Style</label>
                            <input type="text" 
                                   name="footer[style][icon_class]"
                                   class="form-control form-control-sm"
                                   placeholder="Icon classes"
                                   value="{{ old('footer.style.icon_class', $footer['style']['icon_class'] ?? 'text-light') }}">
                        </div>
                    </div>
                </div>
            </div>

            {{-- FOOTER TEXT --}}
            <div class="col-md-6 col-lg-3">
                <div class="settings-card card border h-100" data-section="text">
                    <div class="card-header bg-light">
                        <h6 class="mb-0"><i class="bi bi-type me-2"></i>Footer Text</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label small">Copyright</label>
                            <input type="text" 
                                   name="footer[copyright]"
                                   class="form-control form-control-sm"
                                   placeholder="© 2024 My Company"
                                   value="{{ old('footer.copyright', $footer['copyright'] ?? '') }}">
                        </div>
                        <div class="mb-0">
                            <label class="form-label small">Credit</label>
                            <textarea name="footer[credit]"
                                      class="form-control form-control-sm"
                                      rows="2"
                                      placeholder="Built with love...">{{ old('footer.credit', $footer['credit'] ?? '') }}</textarea>
                            <div class="form-text smaller">HTML allowed for icons/links</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card-footer bg-light border-top py-3">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <button type="reset" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-arrow-clockwise me-1"></i> Reset
                </button>
            </div>
            <button type="submit" class="btn btn-primary px-4">
                <i class="bi bi-save me-1"></i> Save Footer Settings
            </button>
        </div>
    </div>
</form>