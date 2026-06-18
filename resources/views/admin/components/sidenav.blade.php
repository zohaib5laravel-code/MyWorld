<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <div class="sidebar-brand">
        <a href="/admin/dashboard" class="brand-link">
            <span class="brand-text fw-light">Admin Panel</span>
        </a>
    </div>
    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <ul
                class="nav sidebar-menu flex-column"
                data-lte-toggle="treeview"
                role="menu"
                data-accordion="false">
                
                <!-- Dashboard -->
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link {{ Request::routeIs('dashboard') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-speedometer"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <!-- Content Management -->
                <li class="nav-item">
                    <a href="{{ route('posts.index') }}" class="nav-link {{ Request::routeIs(['posts.*', 'posts.index']) ? 'active' : '' }}">
                        <i class="nav-icon bi bi-newspaper"></i>
                        <p>Posts</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('pictures.index') }}" class="nav-link {{ Request::routeIs(['pictures.*', 'pictures.index']) ? 'active' : '' }}">
                        <i class="nav-icon bi bi-images"></i>
                        <p>Pictures</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('categories.index') }}" class="nav-link {{ Request::routeIs(['categories.*', 'categories.index']) ? 'active' : '' }}">
                        <i class="nav-icon bi bi-tags"></i>
                        <p>Categories</p>
                    </a>
                </li>

                <!-- User Interactions -->
                <li class="nav-item">
                    <a href="{{ route('comments.index') }}" class="nav-link {{ Request::routeIs(['comments.*', 'comments.index']) ? 'active' : '' }}">
                        <i class="nav-icon bi bi-chat-quote"></i>
                        <p>Comments</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('messages.index') }}" class="nav-link {{ Request::routeIs(['messages.*', 'messages.index']) ? 'active' : '' }}">
                        <i class="nav-icon bi bi-chat-square-text"></i>
                        <p>Messages</p>
                    </a>
                </li>

                <!-- Settings Dropdown -->
                @php
                $settingsRoutes = [
                    'settings.sections.edit',
                    'settings.about.edit',
                    'settings.contact.edit',
                    'settings.posts.edit',
                    'settings.gallery.edit',
                    'settings.homepage.edit'
                ];
                
                $isSettingsActive = false;
                foreach ($settingsRoutes as $route) {
                    if (Request::routeIs($route)) {
                        $isSettingsActive = true;
                        break;
                    }
                }
                
                // For sub-menu items
                $currentRoute = Route::currentRouteName();
                @endphp

                <li class="nav-item {{ $isSettingsActive ? 'menu-open active' : '' }}">
                    <a href="#" class="nav-link {{ $isSettingsActive ? 'active' : '' }}">
                        <i class="nav-icon bi bi-gear-fill"></i>
                        <p>
                            Settings
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>

                    <ul class="nav nav-treeview" style="{{ $isSettingsActive ? 'display:block;' : '' }}">
                        <!-- Frontend Pages -->
                        <li class="nav-item">
                            <a href="{{ route('settings.homepage.edit') }}"
                                class="nav-link {{ $currentRoute == 'settings.homepage.edit' ? 'active' : '' }}">
                                <i class="nav-icon bi bi-house-door"></i>
                                <p>Home Page</p>
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a href="{{ route('settings.about.edit') }}"
                                class="nav-link {{ $currentRoute == 'settings.about.edit' ? 'active' : '' }}">
                                <i class="nav-icon bi bi-person-circle"></i>
                                <p>About Page</p>
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a href="{{ route('settings.posts.edit') }}"
                                class="nav-link {{ $currentRoute == 'settings.posts.edit' ? 'active' : '' }}">
                                <i class="nav-icon bi bi-newspaper"></i>
                                <p>Posts Page</p>
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a href="{{ route('settings.gallery.edit') }}"
                                class="nav-link {{ $currentRoute == 'settings.gallery.edit' ? 'active' : '' }}">
                                <i class="nav-icon bi bi-images"></i>
                                <p>Gallery Page</p>
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a href="{{ route('settings.contact.edit') }}"
                                class="nav-link {{ $currentRoute == 'settings.contact.edit' ? 'active' : '' }}">
                                <i class="nav-icon bi bi-envelope"></i>
                                <p>Contact Page</p>
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a href="{{ route('settings.sections.edit') }}"
                                class="nav-link {{ $currentRoute == 'settings.sections.edit' ? 'active' : '' }}">
                                <i class="nav-icon bi bi-columns-gap"></i>
                                <p>Sections</p>
                            </a>
                        </li>
                    </ul>
                </li>

            </ul>
        </nav>
    </div>
</aside>

<style>
    /* Active state styling */
    .app-sidebar .nav-link.active {
        background: linear-gradient(135deg, #166088, #4a6fa5) !important;
        color: white !important;
        border-left: 4px solid #fff;
    }
    
    .app-sidebar .nav-link.active .nav-icon {
        color: white !important;
    }
    
    .app-sidebar .nav-link:hover:not(.active) {
        background-color: rgba(255, 255, 255, 0.1) !important;
        color: #e9ecef !important;
    }
    
    .nav-item.menu-open > .nav-link {
        background: linear-gradient(135deg, #4a6fa5, #166088) !important;
        color: #e9ecef !important;
    }
    
    .nav-item.menu-open > .nav-link .nav-icon {
        color: #e9ecef !important;
    }
    
    /* Treeview styling */
    .nav-treeview .nav-link {
        padding-left: 2.5rem !important;
        padding-top: 0.5rem !important;
        padding-bottom: 0.5rem !important;
    }
    
    .nav-treeview .nav-link.active {
        background: linear-gradient(135deg, #4a6fa5, #166088) !important;
        border-left: 4px solid #fff;
    }
    
    .nav-treeview .nav-link .nav-icon.bi-circle {
        font-size: 0.5rem !important;
    }
    
    /* Icon colors */
    .nav-icon {
        color: #adb5bd;
        margin-right: 0.5rem;
    }
    
 
    
    /* Brand styling */
    .sidebar-brand {
        padding: 1rem;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        margin-bottom: 1rem;
    }
    
    .brand-link {
        color: #fff;
        text-decoration: none;
        font-size: 1.2rem;
        font-weight: 600;
    }
    
    .brand-link:hover {
        color: #4a6fa5;
    }
    
    /* Better spacing */
    .sidebar-menu > .nav-item {
        margin-bottom: 0.25rem;
    }
    
    /* Smooth transitions */
    .nav-link {
        transition: all 0.3s ease;
    }
</style>

 