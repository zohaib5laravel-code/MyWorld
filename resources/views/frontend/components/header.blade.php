{{-- resources/views/components/navigation.blade.php --}}
@php
// Get menu settings
$menuSetting = \App\Models\Setting::where('key', 'menu')->first();
$menuData = $menuSetting ? json_decode($menuSetting->value, true) : [];
$menuStatus = $menuSetting ? (bool)$menuSetting->status : true;

//dd($menuData );
// Default data if no settings
$defaults = [
'logo' => [
'type' => 'text',
'text' => 'My World',
'text_color' => '#ffffff',
'text_size' => 24,
'image' => '',
],
'navbar' => [
'bg_color' => 'rgba(21, 26, 34, 0.95)',
'text_color' => '#ffffff',
'hover_color' => '#4a6fa5',
'active_color' => '#166088',
'height' => 70,
'position' => 'fixed-top',
'transparent' => 0,
'show_search' => 0,
],
'items' => [
['label' => 'Home', 'url' => '/', 'route' => 'frontend.home', 'icon' => 'fas fa-home', 'new_tab' => 0],
['label' => 'Gallery', 'url' => '/gallery', 'route' => 'frontend.gallery', 'icon' => 'fas fa-images', 'new_tab' => 0],
['label' => 'Posts', 'url' => '/posts', 'route' => 'frontend.posts', 'icon' => 'fas fa-newspaper', 'new_tab' => 0],
['label' => 'About', 'url' => '/about', 'route' => 'frontend.about', 'icon' => 'fas fa-user-circle', 'new_tab' => 0],
['label' => 'Contact', 'url' => '/contact', 'route' => 'frontend.contact', 'icon' => 'fas fa-envelope', 'new_tab' => 0],
],
'mobile' => [
'enabled' => 1,
'collapse_breakpoint' => 'lg',
'show_icons' => 1,
],
];

// Merge with defaults
$menuData = array_merge($defaults, $menuData);

// Get current route
$currentRoute = Route::currentRouteName();
@endphp

@if($menuStatus)


<nav class="navbar navbar-expand-{{ $menuData['mobile']['collapse_breakpoint'] }} navbar-custom {{ $menuData['navbar']['position'] }}">
    <div class="container">
        {{-- Logo/Brand --}}
        <a class="navbar-brand" href="{{ route('frontend.home') }}">
            @if(in_array($menuData['logo']['type'], ['image', 'both']) && !empty($menuData['logo']['image']))
            <img src="{{ asset('assets/menu/' . $menuData['logo']['image']) }}"
                alt="{{ $menuData['logo']['text'] }}"
                height="40"
                class="me-2">
            @endif
            @if(in_array($menuData['logo']['type'], ['text', 'both']))
            <span class="brand-text">{{ $menuData['logo']['text'] }}</span>
            @endif
        </a>

        {{-- Mobile Toggle --}}
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        {{-- Menu Items --}}
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                @foreach($menuData['items'] as $index => $item)
                @if(isset($item['enabled']) && $item['enabled'])
                @php
                // Check if current route matches


                $isActive = false;
                if (!empty($item['route'])) {
                $isActive = $currentRoute == $item['route'];
                } else {
                $isActive = request()->is(trim($item['url'], '/')) ||
                (trim($item['url'], '/') == '' && request()->is('/'));
                }

                $target = $item['new_tab'] == 1 ? '_blank' : '_self';

                @endphp

                <li class="nav-item">
                    <a class="nav-link {{ $isActive ? 'active' : '' }}"
                        href="{{ $item['url'] }}"
                        target="{{ $target }}"
                        rel="{{ $item['new_tab'] == 1 ? 'noopener noreferrer' : '' }}">
                        @if($menuData['mobile']['show_icons'] == 1 && !empty($item['icon']))
                        <i class="{{ $item['icon'] }} me-1 d-none d-{{ $menuData['mobile']['collapse_breakpoint'] }}-inline"></i>
                        @endif
                        {{ $item['label'] }}
                    </a>
                </li>
                @endif
                @endforeach


            </ul>
        </div>
    </div>
</nav>

@else
{{-- Default menu if disabled --}}
<nav class="navbar navbar-expand-lg navbar-dark fixed-top" style="background: rgba(21, 26, 34, 0.95);">
    <div class="container">
        <a class="navbar-brand" href="{{ route('frontend.home') }}">
            My World
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link {{ $currentRoute == 'frontend.home' ? 'active' : '' }}" href="{{ route('frontend.home') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $currentRoute == 'frontend.gallery' ? 'active' : '' }}" href="{{ route('frontend.gallery') }}">Gallery</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $currentRoute == 'frontend.posts' ? 'active' : '' }}" href="{{ route('frontend.posts') }}">Posts</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $currentRoute == 'frontend.about' ? 'active' : '' }}" href="{{ route('frontend.about') }}">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $currentRoute == 'frontend.contact' ? 'active' : '' }}" href="{{ route('frontend.contact') }}">Contact</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
@endif