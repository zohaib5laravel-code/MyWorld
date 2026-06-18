@extends('admin.app')

@section('content')
<main class="app-main d-flex flex-column">
    <div class="container-fluid flex-grow-1">
        <div class="row h-100">
            <div class="col-lg-12">
                <div class="card h-100 mb-4 shadow-sm">
                    <div class="card-header bg-gradient-primary d-flex justify-content-between align-items-center py-3">
                        <div>
                            <h4 class="mb-0"><i class="bi bi-gear me-2"></i>Sections Settings</h4>
                            <small class="opacity-75">Configure footer and menu settings</small>
                        </div>
                        <div class="form-check form-switch mb-0 ms-auto">
                            <input class="form-check-input" type="checkbox" role="switch" id="livePreviewToggle" checked data-bs-toggle="tooltip" title="Toggle Live Preview">
                            <label class="form-check-label" for="livePreviewToggle">Live Preview</label>
                        </div>
                    </div>

                    <nav>
                        <div class="nav nav-tabs border-0 px-3 pt-3" id="nav-tab" role="tablist">
                            <button class="nav-link active" id="nav-footer-tab" data-bs-toggle="tab" data-bs-target="#nav-footer" type="button" role="tab">
                                <i class="bi bi-layout-text-window-reverse me-2"></i>Footer
                            </button>
                            <button class="nav-link" id="nav-menu-tab" data-bs-toggle="tab" data-bs-target="#nav-menu" type="button" role="tab">
                                <i class="bi bi-list me-2"></i>Menu
                            </button>
                        </div>
                    </nav>

                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-footer" role="tabpanel">
                            @include('admin.settings.partials.footer-form', [
                            'footer' => $footer,
                            'status' => $footer_status,
                            'social_platforms' => $social_platforms
                            ])
                        </div>

                        <div class="tab-pane fade" id="nav-menu" role="tabpanel">
                            @include('admin.settings.partials.menu-form', [
                            'menuData' => $menu,
                            'status' => $menu_status
                            ])
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="preview-container mt-4" id="previewContainer">
        <div class="container-fluid">
            <div class="card shadow-sm">
                <div class="card-header bg-light d-flex justify-content-between align-items-center py-2">
                    <h6 class="mb-0">
                        <i class="bi bi-eye me-2"></i>
                        <span id="previewTitle">Footer Preview</span>
                    </h6>
                </div>
                <div class="card-body p-0">
                    <div id="footerPreview" class="preview-content p-4">
                        @include('admin.settings.partials.footer-preview', [
                        'footer' => $footer,
                        'status' => $footer_status,
                        'isPreview' => true
                        ])
                    </div>

                    <div id="menuPreview" class="preview-content p-4 d-none">
                        @include('admin.settings.partials.menu-preview', [
                        'menuData' => $menu,
                        'status' => $menu_status,
                        'isPreview' => true
                        ])
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection


@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {

        const tabButtons = document.querySelectorAll('#nav-tab button');
        const previewContainer = document.getElementById('previewContainer');
        const previewToggle = document.getElementById('livePreviewToggle');
        const previewTitle = document.getElementById('previewTitle');

        let activeTab = localStorage.getItem('activeSettingsTab') || 'nav-footer';

        const savedTabButton = document.querySelector(`[data-bs-target="#${activeTab}"]`);
        if (savedTabButton) {
            new bootstrap.Tab(savedTabButton).show();
            updatePreview('#' + activeTab);
        }

        tabButtons.forEach(button => {
            button.addEventListener('shown.bs.tab', function(event) {
                const target = event.target.getAttribute('data-bs-target');
                localStorage.setItem('activeSettingsTab', target.replace('#', ''));
                updatePreview(target);
            });
        });

        previewToggle.addEventListener('change', function() {
            previewContainer.style.display = this.checked ? 'block' : 'none';

            if (this.checked) {
                const active = document.querySelector('.nav-link.active');
                if (active) {
                    updatePreview(active.getAttribute('data-bs-target'));
                }
            }
        });

        previewContainer.style.display = previewToggle.checked ? 'block' : 'none';

        function updatePreview(tabTarget) {
            if (!previewToggle.checked) return;

            document.querySelectorAll('.preview-content').forEach(preview => {
                preview.classList.add('d-none');
            });

            if (tabTarget === '#nav-footer') {
                document.getElementById('footerPreview').classList.remove('d-none');
                previewTitle.textContent = 'Footer Preview';
            }

            if (tabTarget === '#nav-menu') {
                document.getElementById('menuPreview').classList.remove('d-none');
                previewTitle.textContent = 'Menu Preview';
            }
        }
        document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(el => {
            new bootstrap.Tooltip(el);
        });

    });
</script>
@endsection