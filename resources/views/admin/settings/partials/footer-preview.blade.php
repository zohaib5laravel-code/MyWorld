@if($status)

@php
$style = $footer['style'] ?? [];
$bgColor = old('footer.style.bg_color', $style['bg_color'] ?? 'bg-dark');
$textColor = old('footer.style.text_color', $style['text_color'] ?? 'text-light');
$iconColor = old('footer.style.icon_color', $style['icon_color'] ?? 'text-light');
@endphp

<footer id="contact" class="{{ $bgColor }} {{ $textColor }} py-5">
    <div class="container">
        <div class="row">
            {{-- About Section --}}
            <div class="col-lg-4 mb-4">
                @if(!empty($footer['about']['title']))
                <h3 class="mb-4"><i class="fas fa-globe-americas me-2 {{ $iconColor }}"></i>{{ old('footer.about.title', $footer['about']['title'] ?? 'My World') }}</h3>
                @endif

                @if(!empty($footer['about']['description']))
                <p>{{ old('footer.about.description', $footer['about']['description'] ?? 'A personal website to share my journey through photos, stories, and experiences. Built with Laravel and Bootstrap.') }}</p>
                @endif

                <div class="social-icons mt-4">
                    @foreach($social_platforms as $social)
                    @php
                    $socialUrl = old("footer.about.social.$social", $footer['about']['social'][$social] ?? '#');
                    @endphp
                    <a href="{{ $socialUrl }}" class="{{ $iconColor }} me-3">
                        <i class="fab fa-{{ $social }} fa-lg"></i>
                    </a>
                    @endforeach
                </div>
            </div>

            {{-- Quick Links --}}
            <div class="col-lg-4 mb-4">
                <h4 class="mb-4">Quick Links</h4>
                <ul class="list-unstyled">
                    @foreach(old('footer.quick_links', $footer['quick_links'] ?? []) as $link)
                    @if(!empty($link['label']))
                    <li class="mb-2">
                        <a href="{{ $link['url'] ?? '#' }}" class="{{ $textColor }} text-decoration-none">
                            {{ $link['label'] }}
                        </a>
                    </li>
                    @endif
                    @endforeach
                </ul>
            </div>

            {{-- Contact & Newsletter --}}
            <div class="col-lg-4 mb-4">
                <h4 class="mb-4">Get In Touch</h4>

                @if(!empty($footer['contact']['email']))
                <p><i class="fas fa-envelope me-2 {{ $iconColor }}"></i> {{ old('footer.contact.email', $footer['contact']['email'] ?? 'contact@myworld.com') }}</p>
                @endif

                @if(!empty($footer['contact']['phone']))
                <p><i class="fas fa-phone me-2 {{ $iconColor }}"></i> {{ old('footer.contact.phone', $footer['contact']['phone'] ?? '+1 (555) 123-4567') }}</p>
                @endif

                @if(!empty($footer['contact']['address']))
                <p><i class="fas fa-map-marker-alt me-2 {{ $iconColor }}"></i> {{ old('footer.contact.address', $footer['contact']['address'] ?? '123 Personal Street, Memory City, MC 12345') }}</p>
                @endif

                @if(!empty($footer['newsletter']['enabled']))
                <div class="mt-4">
                    <p>Subscribe to my newsletter for updates</p>
                    <div class="input-group">
                        <input type="email" class="form-control" placeholder="{{ old('footer.newsletter.placeholder', $footer['newsletter']['placeholder'] ?? 'Your email') }}" disabled>
                        <button class="btn btn-primary" type="button">
                            {{ old('footer.newsletter.button_text', $footer['newsletter']['button_text'] ?? 'Subscribe') }}
                        </button>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <hr class="bg-light">

        <div class="row mt-4">
            <div class="col-md-6">
                <p>{{ old('footer.copyright', $footer['copyright'] ?? '© ' . date('Y') . ' My World. All rights reserved.') }}</p>
            </div>
            <div class="col-md-6 text-md-end">
                <p>{!! old('footer.credit', $footer['credit'] ?? 'Built with <i class="fas fa-heart text-danger"></i> using Laravel & Bootstrap') !!}</p>
            </div>
        </div>
    </div>
</footer>
@else
<div class="alert alert-warning text-center py-5">
    <i class="bi bi-eye-slash fs-1 d-block mb-3"></i>
    <h4 class="alert-heading">Footer is Disabled</h4>
    <p class="mb-0">Enable the footer from the settings above to see the preview.</p>
</div>
@endif