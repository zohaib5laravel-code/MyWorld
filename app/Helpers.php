<?php

use App\Models\Picture;
use App\Models\Post;
use App\Models\Setting;

function uploadImage($file, $folder)
{
    $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
    $file->move($folder, $filename);
    return $filename;
}

function getFooterData()
{
    $footerSetting = Setting::where('key', 'footer')->first();

    if (!$footerSetting) {
        return getDefaultFooterData();
    }

    $footerData = json_decode($footerSetting->value, true) ?? [];

    if ($footerSetting->status == 1) {
        $defaults = getDefaultFooterData();
        $footer = array_merge($defaults, $footerData);
        $footer['status'] = true;
        return $footer;
    }

    return ['status' => false];
}

function getDefaultFooterData()
{
    return [
        'status' => true,
        'about' => [
            'title' => 'My World',
            'description' => 'A personal website to share my journey through photos, stories, and experiences.',
            'social' => [
                'instagram' => '#',
                'twitter' => '#',
                'facebook' => '#',
                'pinterest' => '#',
                'youtube' => '#'
            ]
        ],
        'quick_links' => [
            ['label' => 'Home', 'url' => route('frontend.home')],
            ['label' => 'Gallery', 'url' => '#gallery'],
            ['label' => 'Posts', 'url' => route('frontend.posts')],
            ['label' => 'About', 'url' => route('frontend.about')],
            ['label' => 'Contact', 'url' => route('frontend.contact')]
        ],
        'social_platforms' => ['instagram', 'twitter', 'facebook', 'pinterest', 'youtube'],
        'contact' => [
            'email' => 'contact@myworld.com',
            'phone' => '+1 (555) 123-4567',
            'address' => '123 Personal Street, Memory City, MC 12345'
        ],
        'newsletter' => [
            'enabled' => true,
            'placeholder' => 'Your email',
            'button_text' => 'Subscribe'
        ],
        'style' => [
            'bg_color' => 'bg-dark',
            'text_color' => 'text-light',
            'icon_color' => 'text-light'
        ],
        'copyright' => '© ' . date('Y') . ' My World. All rights reserved.',
        'credit' => 'Built with Laravel & Bootstrap'
    ];
}

function getAboutData()
{
    $aboutSetting = Setting::where('key', 'about')->first();
    
    if (!$aboutSetting) {
        return getDefaultAboutData();
    }
    
    $aboutData = json_decode($aboutSetting->value, true) ?? [];
    
    if ($aboutSetting->status == 1) {
        $defaults = getDefaultAboutData();
        $data = array_merge_recursive_distinct($defaults, $aboutData);
        $data['status'] = true;
        return $data;
    }
    
    return ['status' => false];
}

function getDefaultAboutData()
{
    return [
        'status' => true,
        'images' => [
            'hero_bg' => '',
            'profile' => '',
        ],
        'hero' => [
            'text' => 'Welcome to my personal corner of the internet',
            'button_text' => 'My Story',
        ],
        'personalInfo' => [
            'name' => 'Alex',
            'location' => 'Somewhere Beautiful',
            'bio' => 'A curious soul wandering through life with a camera in hand and stories in heart.',
            'mission' => 'To capture the beauty in ordinary moments and share stories that connect us all.',
            'quote' => '"The world is full of stories waiting to be told, and I\'m here to listen."',
            'interests' => ['Photography', 'Writing', 'Hiking', 'Coffee Brewing', 'Reading', 'Stargazing'],
            'start_year' => 2018,
        ],
        'stats' => [
            'title' => 'My World in Numbers',
            'totalPosts' => Post::where('status','published')->count(),
            'totalPhotos' => Picture::where('type','gallery')->count(),
            'countriesFeatured' => 24,
            'yearsWriting' => date('Y') - 2018,
            'labels' => [
                'stories' => 'Stories Shared',
                'moments' => 'Moments Captured',
                'countries' => 'Countries Featured',
                'years' => 'Years of Journey',
            ],
        ],
        'values' => [
            'title' => 'What Guides My Journey',
            'items' => [
                ['icon' => 'fas fa-heart', 'title' => 'Authenticity', 'description' => 'Keeping it real.'],
                ['icon' => 'fas fa-compass', 'title' => 'Curiosity', 'description' => 'Always exploring.'],
                ['icon' => 'fas fa-hands', 'title' => 'Connection', 'description' => 'Building bridges.'],
                ['icon' => 'fas fa-sun', 'title' => 'Positivity', 'description' => 'Finding light.'],
            ],
        ],
        'journey' => [
            'title' => 'My Journey So Far',
            'items' => [
                ['year' => '2018', 'title' => 'The First Click', 'description' => 'Started documenting my daily life.'],
                ['year' => '2019', 'title' => 'Finding My Voice', 'description' => 'Began writing alongside photos.'],
                ['year' => '2020', 'title' => 'Going Digital', 'description' => 'Created My World blog.'],
                ['year' => '2021', 'title' => 'First Solo Trip', 'description' => 'Traveled across the country.'],
                ['year' => '2022', 'title' => 'Finding Community', 'description' => 'Connected with fellow creators.'],
                ['year' => '2023', 'title' => 'New Perspective', 'description' => 'Redesigned My World.'],
            ],
        ],
        'favorites' => [
            'title' => 'My Favorites',
            'items' => [
                ['type' => 'Camera Gear', 'items' => ['Canon EOS R5', '24-70mm Lens', 'Tripod', 'Filters']],
                ['type' => 'Travel Essentials', 'items' => ['Journal', 'Coffee Kit', 'Shoes', 'Charger']],
                ['type' => 'Creative Tools', 'items' => ['Notebook', 'Pen', 'iPad Pro', 'Headphones']],
                ['type' => 'Reading List', 'items' => ['Into the Wild', 'The Alchemist', 'Wild', 'Photographer\'s Eye']],
            ],
        ],
        'contact' => [
            'title' => 'Let\'s Connect',
            'description' => 'I love connecting with fellow travelers, photographers, and story lovers.',
            'social' => [
                'instagram' => '#',
                'twitter' => '#',
                'pinterest' => '#',
                'email' => '#',
            ],
        ],
        'settings' => [
            'show_hero_images' => true,
            'show_personal_info' => true,
            'show_stats' => true,
            'show_values' => true,
            'show_journey' => true,
            'show_favorites' => true,
            'show_contact' => true,
        ]
    ];
}

function getContactData()
{
    $contactSetting = Setting::where('key', 'contact')->first();
    
    if (!$contactSetting) {
        return getDefaultContactData();
    }
    
    $contactData = json_decode($contactSetting->value, true) ?? [];
    
    if ($contactSetting->status == 1) {
        $defaults = getDefaultContactData();
        $data = array_merge_recursive_distinct($defaults, $contactData);
        $data['status'] = true;
        return $data;
    }
    
    return ['status' => false];
}

function getDefaultContactData()
{
    return [
        'status' => true,
        'hero' => [
            'title' => 'Let\'s Connect',
            'description' => 'Have questions, ideas, or just want to say hello?',
            'response_time' => 'I typically respond within 24-48 hours.',
        ],
        'contactInfo' => [
            'email' => 'hello@myworld.com',
            'phone' => '+1 (555) 123-4567',
            'address' => '123 Creative Street, Inspiration City, IC 12345',
            'emergency_contact' => 'For urgent matters, please call.',
            'preferred_contact' => 'Email is the best way to reach me.',
            'social' => [
                ['platform' => 'instagram', 'icon' => 'fab fa-instagram', 'url' => '#', 'handle' => '@myworld'],
                ['platform' => 'twitter', 'icon' => 'fab fa-twitter', 'url' => '#', 'handle' => '@myworld'],
                ['platform' => 'pinterest', 'icon' => 'fab fa-pinterest', 'url' => '#', 'handle' => '@myworld'],
                ['platform' => 'youtube', 'icon' => 'fab fa-youtube', 'url' => '#', 'handle' => 'My World'],
            ],
            'businessHours' => [
                ['day' => 'Monday - Friday', 'hours' => '9:00 AM - 6:00 PM', 'status' => 'open'],
                ['day' => 'Saturday', 'hours' => '10:00 AM - 4:00 PM', 'status' => 'limited'],
                ['day' => 'Sunday', 'hours' => 'Closed', 'status' => 'closed'],
            ],
            'faqs' => [
                ['question' => 'How long does it take to get a response?', 'answer' => 'I typically respond within 24-48 hours.'],
                ['question' => 'Do you accept guest posts?', 'answer' => 'Yes! I welcome guest posts.'],
                ['question' => 'Can I use your photos for personal projects?', 'answer' => 'Most photos are available for personal use.'],
                ['question' => 'Do you offer photography services?', 'answer' => 'Yes, I offer limited photography services.'],
                ['question' => 'Can I collaborate with you?', 'answer' => 'Absolutely! I\'m always open to collaborations.'],
                ['question' => 'Do you have a newsletter?', 'answer' => 'Yes! You can subscribe on the homepage.'],
            ],
        ],
        'map' => [
            'title' => 'Find Me Here',
            'latitude' => '40.7128',
            'longitude' => '-74.0060',
            'zoom' => '13',
            'marker_title' => 'My World Headquarters',
            'marker_description' => 'Creative Street, Inspiration City',
        ],
        'form' => [
            'title' => 'Send Me a Message',
            'button_text' => 'Send Message',
            'button_icon' => 'fas fa-paper-plane',
            'success_message' => 'Your message has been sent successfully!',
            'enable_captcha' => false,
        ],
        'faq' => [
            'title' => 'Frequently Asked Questions',
        ],
        'settings' => [
            'show_hero' => true,
            'show_form' => true,
            'show_contact_info' => true,
            'show_social' => true,
            'show_business_hours' => true,
            'show_map' => true,
            'show_faq' => true,
            'enable_contact_form' => true,
        ],
    ];
}

function getPostsPageData()
{
    $postsSetting = Setting::where('key', 'posts')->first();
    
    if (!$postsSetting) {
        return getDefaultPostsPageData();
    }
    
    $postsData = json_decode($postsSetting->value, true) ?? [];
    
    if ($postsSetting->status == 1) {
        $defaults = getDefaultPostsPageData();
        $data = array_merge_recursive_distinct($defaults, $postsData);
        $data['status'] = true;
        return $data;
    }
    
    return ['status' => false];
}

function getDefaultPostsPageData()
{
    return [
        'status' => true,
        'hero' => [
            'title' => 'My Stories & Thoughts',
            'description' => 'Explore my journey through personal stories.',
            'search_placeholder' => 'Search posts...',
            'hero_bg' => '',
        ],
        'filter' => [
            'show_search' => true,
            'show_category_filter' => true,
            'show_sort_options' => true,
            'default_sort' => 'newest',
            'default_category' => null,
        ],
        'layout' => [
            'posts_per_page' => 8,
            'show_sidebar' => true,
            'grid_columns' => 2,
        ],
        'sidebar' => [
            'show_about_widget' => true,
            'show_categories_widget' => true,
            'show_popular_posts_widget' => true,
            'show_newsletter_widget' => true,
            'about_widget_title' => 'About This Blog',
            'about_widget_content' => 'Welcome to my personal blog.',
            'popular_posts_title' => 'Popular Posts',
            'popular_posts_count' => 5,
        ],
        'empty_state' => [
            'title' => 'No Posts Found',
            'message' => 'Try adjusting your search.',
        ],
        'pagination' => [
            'show_pagination' => true,
            'type' => 'both',
        ],
        'meta' => [
            'meta_title' => 'My Stories & Thoughts | Blog',
            'meta_description' => 'Explore personal stories.',
            'meta_keywords' => 'blog, stories, thoughts, personal',
        ],
    ];
}

function getGalleryData()
{
    $gallerySetting = Setting::where('key', 'gallery')->first();
    
    if (!$gallerySetting) {
        return getDefaultGalleryData();
    }
    
    $galleryData = json_decode($gallerySetting->value, true) ?? [];
    
    if ($gallerySetting->status == 1) {
        $defaults = getDefaultGalleryData();
        $data = array_merge_recursive_distinct($defaults, $galleryData);
        $data['status'] = true;
        return $data;
    }
    
    return ['status' => false];
}

function getDefaultGalleryData()
{
    return [
        'status' => true,
        'hero' => [
            'title' => 'My Visual Journey',
            'description' => 'Explore my world through photographs.',
            'show_stats' => 1,
            'hero_bg' => '',
        ],
        'filter' => [
            'show_sort_options' => 1,
            'default_sort' => 'newest',
        ],
        'layout' => [
            'pictures_per_page' => 12,
            'show_sidebar' => 1,
            'grid_columns' => 3,
            'masonry_enabled' => 1,
        ],
        'sidebar' => [
            'show_categories_widget' => 1,
            'show_recent_photos_widget' => 1,
            'show_tips_widget' => 1,
            'recent_photos_title' => 'Recent Photos',
            'recent_photos_count' => 8,
            'tips_title' => 'Gallery Tips',
        ],
        'empty_state' => [
            'title' => 'No Photos Found',
            'message' => 'The gallery is empty.',
        ],
        'pagination' => [
            'show_pagination' => 1,
        ],
        'lightbox' => [
            'enabled' => 1,
            'show_download_button' => 1,
            'show_fullscreen_button' => 1,
            'show_thumbnails' => 1,
            'keyboard_navigation' => 1,
        ],
        'meta' => [
            'meta_title' => 'My Visual Journey | Photo Gallery',
            'meta_description' => 'Explore my photography gallery.',
            'meta_keywords' => 'gallery, photography, photos',
        ],
    ];
}

function getHomepageData()
{
    $homepageSetting = Setting::where('key', 'homepage')->first();
    
    if (!$homepageSetting) {
        return getDefaultHomepageData();
    }
    
    $homepageData = json_decode($homepageSetting->value, true) ?? [];
    
    if ($homepageSetting->status == 1) {
        $defaults = getDefaultHomepageData();
        $data = array_merge_recursive_distinct($defaults, $homepageData);
        $data['status'] = true;
        return $data;
    }
    
    return ['status' => false];
}

function getDefaultHomepageData()
{
    return [
        'status' => true,
        'hero' => [
            'title' => 'Welcome to <span class="text-warning">My World</span>',
            'subtitle' => 'This is my personal space where I share my journey.',
            'button1_text' => 'Explore Gallery',
            'button1_url' => '#gallery',
            'button2_text' => 'Read Posts',
            'button2_url' => '#posts',
            'show_world_icon' => 1,
            'hero_bg' => '',
            'enabled' => 1,
        ],
        'carousel' => [
            'enabled' => 1,
            'interval' => 5000,
            'show_indicators' => 1,
            'show_controls' => 1,
            'show_captions' => 1,
            'height' => 500,
        ],
        'posts' => [
            'enabled' => 1,
            'title' => 'Recent Posts',
            'subtitle' => '',
            'show_button' => 1,
            'button_text' => 'View All Posts',
            'posts_count' => 3,
            'show_featured_image' => 1,
            'show_date' => 1,
            'show_category' => 1,
            'show_excerpt' => 1,
            'excerpt_length' => 150,
        ],
        'gallery' => [
            'enabled' => 1,
            'title' => 'Photo Gallery',
            'subtitle' => 'A collection of my favorite moments.',
            'show_button' => 1,
            'button_text' => 'View Full Gallery',
            'images_count' => 6,
            'show_overlay' => 1,
            'columns' => 3,
        ],
        'about' => [
            'enabled' => 1,
            'title' => 'About My World',
            'content' => 'Welcome to my personal corner of the internet.',
            'show_image' => 1,
            'image_url' => 'https://images.unsplash.com/photo-1551632811-561732d1e306?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80',
            'show_social_icons' => 1,
            'social_links' => [
                ['platform' => 'instagram', 'url' => '#', 'icon' => 'fab fa-instagram'],
                ['platform' => 'twitter', 'url' => '#', 'icon' => 'fab fa-twitter'],
                ['platform' => 'facebook', 'url' => '#', 'icon' => 'fab fa-facebook'],
                ['platform' => 'pinterest', 'url' => '#', 'icon' => 'fab fa-pinterest'],
            ],
        ],
        'meta' => [
            'meta_title' => 'My World | Personal Blog & Gallery',
            'meta_description' => 'Welcome to My World - a personal space.',
            'meta_keywords' => 'personal blog, photo gallery, travel, photography',
        ],
    ];
}

function getMenuData()
{
    $menuSetting = Setting::where('key', 'menu')->first();
    
    if (!$menuSetting) {
        return getDefaultMenuData();
    }
    
    $menuData = json_decode($menuSetting->value, true) ?? [];
    
    if ($menuSetting->status == 1) {
        $defaults = getDefaultMenuData();
        $data = array_merge_recursive_distinct($defaults, $menuData);
        $data['status'] = true;
        return $data;
    }
    
    return ['status' => false];
}

function getDefaultMenuData()
{
    return [
        'status' => true,
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
            'show_home' => 1,
            'show_gallery' => 1,
            'show_posts' => 1,
            'show_about' => 1,
            'show_contact' => 1,
            'show_search' => 0,
        ],
        'items' => [
            [
                'label' => 'Home',
                'url' => '/',
                'route' => 'frontend.home',
                'icon' => 'fas fa-home',
                'enabled' => 1,
                'new_tab' => 0,
            ],
            [
                'label' => 'Gallery',
                'url' => '/gallery',
                'route' => 'frontend.gallery',
                'icon' => 'fas fa-images',
                'enabled' => 1,
                'new_tab' => 0,
            ],
            [
                'label' => 'Posts',
                'url' => '/posts',
                'route' => 'frontend.posts',
                'icon' => 'fas fa-newspaper',
                'enabled' => 1,
                'new_tab' => 0,
            ],
            [
                'label' => 'About',
                'url' => '/about',
                'route' => 'frontend.about',
                'icon' => 'fas fa-user-circle',
                'enabled' => 1,
                'new_tab' => 0,
            ],
            [
                'label' => 'Contact',
                'url' => '/contact',
                'route' => 'frontend.contact',
                'icon' => 'fas fa-envelope',
                'enabled' => 1,
                'new_tab' => 0,
            ],
        ],
        'mobile' => [
            'enabled' => 1,
            'collapse_breakpoint' => 'lg',
            'show_icons' => 1,
        ],
    ];
}

if (!function_exists('array_merge_recursive_distinct')) {
    function array_merge_recursive_distinct(array $array1, array $array2)
    {
        $merged = $array1;
        
        foreach ($array2 as $key => &$value) {
            if (is_array($value) && isset($merged[$key]) && is_array($merged[$key])) {
                if (is_assoc_array($value)) {
                    $merged[$key] = array_merge_recursive_distinct($merged[$key], $value);
                } else {
                    $merged[$key] = $value;
                }
            } else {
                $merged[$key] = $value;
            }
        }
        
        return $merged;
    }
}

if (!function_exists('is_assoc_array')) {
    function is_assoc_array(array $arr)
    {
        if (array() === $arr) return false;
        return array_keys($arr) !== range(0, count($arr) - 1);
    }
}