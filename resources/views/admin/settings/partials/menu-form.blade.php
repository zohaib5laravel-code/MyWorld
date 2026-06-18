<form action="{{ route('settings.menu.update') }}" method="POST" id="menuForm" enctype="multipart/form-data">
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
                <small class="text-muted ms-2">When inactive, default menu will be shown</small>
            </div>
        </div>
        
        {{-- Logo & Brand Settings --}}
        <div class="card border mb-4">
            <div class="card-header bg-light py-2">
                <h6 class="mb-0"><i class="fas fa-image me-2"></i>Logo & Brand</h6>
            </div>
            <div class="card-body p-3">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="mb-2">
                            <label class="form-label small fw-bold mb-1">Logo Type</label>
                            <select name="logo[type]" class="form-select form-select-sm">
                                <option value="text" {{ old('logo.type', $menuData['logo']['type'] ?? 'text') == 'text' ? 'selected' : '' }}>Text Only</option>
                                <option value="image" {{ old('logo.type', $menuData['logo']['type'] ?? 'text') == 'image' ? 'selected' : '' }}>Image Only</option>
                                <option value="both" {{ old('logo.type', $menuData['logo']['type'] ?? 'text') == 'both' ? 'selected' : '' }}>Text & Image</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-2">
                            <label class="form-label small fw-bold mb-1">Logo Text</label>
                            <input type="text" 
                                   name="logo[text]" 
                                   class="form-control form-control-sm"
                                   value="{{ old('logo.text', $menuData['logo']['text'] ?? 'My World') }}">
                        </div>
                    </div>
                    
                    <div class="col-12">
                        <label class="form-label small fw-bold mb-1">Logo Image</label>
                        <div class="image-upload-wrapper">
                            <div class="image-preview mb-2" id="logoPreview">
                                @if(!empty($menuData['logo']['image']))
                                    <img src="{{ asset('assets/menu/' . $menuData['logo']['image']) }}" 
                                         class="img-fluid rounded" 
                                         style="max-height: 100px;">
                                    <div class="mt-1">
                                        <div class="form-check">
                                            <input class="form-check-input" 
                                                   type="checkbox" 
                                                   name="remove_images[logo]" 
                                                   value="1"
                                                   id="removeLogo">
                                            <label class="form-check-label text-danger small" for="removeLogo">
                                                Remove
                                            </label>
                                        </div>
                                    </div>
                                @else
                                    <div class="border rounded p-2 text-center bg-light">
                                        <i class="fas fa-image fa-2x text-muted mb-2"></i>
                                        <p class="mb-0 text-muted small">No logo image</p>
                                    </div>
                                @endif
                            </div>
                            <input type="file" 
                                   name="logo_image" 
                                   class="form-control form-control-sm" 
                                   id="logoInput"
                                   accept="image/*">
                            <input type="hidden" 
                                   name="current_images[logo]" 
                                   value="{{ $menuData['logo']['image'] ?? '' }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        {{-- Menu Items --}}
        <div class="card border mb-4">
            <div class="card-header bg-light py-2 d-flex justify-content-between align-items-center">
                <h6 class="mb-0"><i class="fas fa-list me-2"></i>Menu Items</h6>
             
            </div>
            <div class="card-body p-3">
                <div id="menuItemsContainer">
                    @php
                        $items = old('items', $menuData['items'] ?? $this->getDefaultMenuData()['items']);
                    @endphp
                    
                    @foreach($items as $index => $item)
                    <div class="menu-item card mb-2" data-index="{{ $index }}">
                        <div class="card-body p-2">
                            <div class="row g-2 align-items-center">
                                <div class="col-md-3">
                                    <input type="text" 
                                           name="items[{{ $index }}][label]"
                                           class="form-control form-control-sm"
                                           value="{{ $item['label'] ?? '' }}"
                                           placeholder="Label"
                                           required>
                                </div>
                                
                                <div class="col-md-3">
                                    <input type="text" 
                                           name="items[{{ $index }}][url]"
                                           class="form-control form-control-sm"
                                           value="{{ $item['url'] ?? '' }}"
                                           placeholder="URL"
                                           required>
                                </div>
                                
                             
                                
                                <div class="col-md-2">
                                    <div class="form-check form-switch m-0">
                                        <input type="hidden" name="items[{{ $index }}][enabled]" value="0">
                                        <input class="form-check-input" 
                                               type="checkbox" 
                                               name="items[{{ $index }}][enabled]"
                                               value="1"
                                               {{ isset($item['enabled']) && $item['enabled'] == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label small">Enabled</label>
                                    </div>
                                </div>
                                
                                <div class="col-md-2">
                                    <div class="form-check form-switch m-0">
                                        <input type="hidden" name="items[{{ $index }}][new_tab]" value="0">
                                        <input class="form-check-input" 
                                               type="checkbox" 
                                               name="items[{{ $index }}][new_tab]"
                                               value="1"
                                               {{ isset($item['new_tab']) && $item['new_tab'] == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label small">New Tab</label>
                                    </div>
                                </div>                               
                              
                            </div>
                        </div>
                    </div>
                    @endforeach
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



<script>
document.addEventListener('DOMContentLoaded', function() {
    // Image preview for logo
    const logoInput = document.getElementById('logoInput');
    const logoPreview = document.getElementById('logoPreview');
    
    if (logoInput && logoPreview) {
        logoInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    logoPreview.innerHTML = `
                        <img src="${e.target.result}" class="img-fluid rounded" style="max-height: 100px;">
                        <div class="mt-1">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remove_images[logo]" value="1" id="removeLogo">
                                <label class="form-check-label text-danger small" for="removeLogo">Remove</label>
                            </div>
                        </div>
                    `;
                };
                reader.readAsDataURL(this.files[0]);
            }
        });
    }
    
 
    
});
</script>