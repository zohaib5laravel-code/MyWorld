{{-- resources/views/admin/settings/partials/menu-preview.blade.php --}}
<div class="menu-preview">
    <nav class="navbar navbar-expand-lg navbar-light " style="background: rgba(205, 205, 215, 0.95) !important">
        <div class="container">
            @if(!empty($menuData['logo']['image']))
                <a class="navbar-brand" href="#">
                    <img src="{{ asset('assets/menu/' . $menuData['logo']['image']) }}" 
                         alt="{{ $menuData['logo']['text'] ?? 'Logo' }}"
                         height="40"
                         class="d-inline-block align-text-top me-2">
                    <span>{{ $menuData['logo']['text'] ?? 'My World' }}</span>
                </a>
            @else
                <a class="navbar-brand text-primary" href="#">
                    {{ $menuData['logo']['text'] ?? 'My World' }}
                </a>
            @endif
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#previewNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="previewNavbar">
                <ul class="navbar-nav ms-auto">
                    @foreach($menuData['items'] ?? [] as $item)
                        @if($item['enabled'] ?? true)
                            <li class="nav-item">
                                <a class="nav-link" 
                                   href="{{ $item['url'] ?? '#' }}"
                                   {{ $item['new_tab'] ?? false ? 'target="_blank"' : '' }}>
                               
                                    {{ $item['label'] ?? 'Menu Item' }}
                                </a>
                            </li>
                        @endif
                    @endforeach
                    
                    {{-- Add default items if no custom items exist --}}
                    @if(empty($menuData['items']))
                        <li class="nav-item">
                            <a class="nav-link active" href="#">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Gallery</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Posts</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">About</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Contact</a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
    
    {{-- Spacer to show the navbar properly --}}
    <div style="height: 70px;"></div>
    
    {{-- Preview Note --}}
    <div class="alert alert-info mt-3 mb-0">
        <i class="bi bi-info-circle me-2"></i>
        This is a preview of how your menu will appear. Colors and styling reflect your current settings.
    </div>
</div>