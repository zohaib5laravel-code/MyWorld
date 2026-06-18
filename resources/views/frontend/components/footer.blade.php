 @php
$footer = getFooterData();
 @endphp


@if($footer['status'] ?? false)
    @php
        $style = $footer['style'] ?? [];
        $bgColor = $style['bg_color'] ?? 'bg-dark';
        $textColor = $style['text_color'] ?? 'text-light';
        $iconColor = $style['icon_color'] ?? 'text-light';
    @endphp
    
    <footer id="contact" class="{{ $bgColor }} {{ $textColor }} py-5 mt-5">
        <div class="container">
            <div class="row">
                {{-- About Section --}}
                <div class="col-lg-4 mb-4">
                    @if(!empty($footer['about']['title']))
                        <h1 style="font-size: 30px;" class="mb-4">
                            {{ $footer['about']['title'] }}
                        </h1>
                    @endif
                    
                    @if(!empty($footer['about']['description']))
                        <p>{{ $footer['about']['description'] }}</p>
                    @endif
                    
                    @if(!empty($footer['about']['social']) && is_array($footer['about']['social']))
                        <div class="social-icons mt-4">
                            @foreach($footer['social_platforms'] as $platform)
                                @if(!empty($footer['about']['social'][$platform]))
                                    <a href="{{ $footer['about']['social'][$platform] }}" 
                                       class="{{ $iconColor }} me-3" 
                                       target="_blank" 
                                       rel="noopener noreferrer"
                                       title="{{ ucfirst($platform) }}">
                                        <i class="fab fa-{{ $platform }} fa-lg"></i>
                                    </a>
                                @endif
                            @endforeach
                        </div>
                    @endif
                </div>
                
                {{-- Quick Links --}}
                @if(!empty($footer['quick_links']) && is_array($footer['quick_links']))
                    <div class="col-lg-4 mb-4">
                        <h1 style="font-size: 30px;" class="mb-4">Quick Links</h1>
                        <ul class="list-unstyled">
                            @foreach($footer['quick_links'] as $link)
                                @if(!empty($link['label']) && !empty($link['url']))
                                    <li class="mb-2">
                                        <a href="{{ $link['url'] }}" 
                                           class="{{ $textColor }} text-decoration-none">
                                            <i class="fas fa-chevron-right me-2 {{ $iconColor }} fa-xs"></i>
                                            {{ $link['label'] }}
                                        </a>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                {{-- Contact & Newsletter --}}
                <div class="col-lg-4 mb-4">
                    <h1 style="font-size: 30px;" class="mb-4">Get In Touch</h1>
                    
                    @if(!empty($footer['contact']['email']))
                        <p class="mb-3">
                            <i class="fas fa-envelope me-2 {{ $iconColor }}"></i>
                            <a href="mailto:{{ $footer['contact']['email'] }}" class="{{ $textColor }} text-decoration-none">
                                {{ $footer['contact']['email'] }}
                            </a>
                        </p>
                    @endif
                    
                    @if(!empty($footer['contact']['phone']))
                        <p class="mb-3">
                            <i class="fas fa-phone me-2 {{ $iconColor }}"></i>
                            <a href="tel:{{ $footer['contact']['phone'] }}" class="{{ $textColor }} text-decoration-none">
                                {{ $footer['contact']['phone'] }}
                            </a>
                        </p>
                    @endif
                    
                    @if(!empty($footer['contact']['address']))
                        <p class="mb-4">
                            <i class="fas fa-map-marker-alt me-2 {{ $iconColor }}"></i>
                            {{ $footer['contact']['address'] }}
                        </p>
                    @endif
                    
                    {{-- Newsletter --}}
                    @if(!empty($footer['newsletter']['enabled']))
                        <div class="mt-4">
                            <p class="mb-2">Subscribe to my newsletter for updates</p>
                            <form action="{{ 1 }}" method="POST" class="newsletter-form">
                                @csrf
                                <div class="input-group">
                                    <input type="email" 
                                           name="email" 
                                           class="form-control" 
                                           placeholder="{{ $footer['newsletter']['placeholder'] ?? 'Your email' }}"
                                           required>
                                    <button class="btn btn-primary" type="submit">
                                        {{ $footer['newsletter']['button_text'] ?? 'Subscribe' }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
            
            <hr class="{{ $textColor }} opacity-50">
            
            <div class="row mt-4">
                <div class="col-md-6">
                    <p class="mb-0">{{ $footer['copyright'] ?? '' }}</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="mb-0">{!! $footer['credit'] ?? '' !!}</p>
                </div>
            </div>
        </div>
    </footer>
@else
    {{-- Footer disabled message --}}
    <div class="text-center py-4 bg-light text-muted border-top">
        <small><i class="fas fa-eye-slash me-1"></i> Footer is currently disabled</small>
    </div>
@endif
