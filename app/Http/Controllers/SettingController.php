<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SettingController extends Controller
{
    private function handleBooleanFields($validated, $booleanFields)
    {
        foreach ($booleanFields as $field) {
            $keys = explode('.', $field);
            $lastKey = array_pop($keys);
            $array = &$validated;

            foreach ($keys as $key) {
                if (!isset($array[$key]) || !is_array($array[$key])) {
                    $array[$key] = [];
                }
                $array = &$array[$key];
            }

            if (!isset($array[$lastKey])) {
                $array[$lastKey] = 0;
            } else {
                $array[$lastKey] = $array[$lastKey] ? 1 : 0;
            }
        }

        return $validated;
    }

    public function editAbout()
    {
        $setting = Setting::where('key', 'about')->first();

        $aboutData = $setting ? json_decode($setting->value, true) : [];

        $aboutData = array_merge(getDefaultAboutData(), $aboutData);

        return view('admin.settings.about', [
            'aboutData' => $aboutData,
            'status' => $setting->status ?? 1
        ]);
    }

    public function updateAbout(Request $request)
    {
        $validated = $request->validate([
            'status' => 'required|boolean',
            'hero_bg_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'hero.text' => 'nullable|string|max:500',
            'hero.button_text' => 'nullable|string|max:100',
            'personalInfo.name' => 'required|string|max:100',
            'personalInfo.location' => 'nullable|string|max:200',
            'personalInfo.bio' => 'required|string|max:1000',
            'personalInfo.mission' => 'nullable|string|max:1000',
            'personalInfo.quote' => 'nullable|string|max:500',
            'personalInfo.start_year' => 'nullable|integer|min:1900|max:' . date('Y'),
            'personalInfo.interests' => 'required|array|min:1',
            'personalInfo.interests.*' => 'required|string|max:100',

            'values.title' => 'nullable|string|max:200',
            'values.items' => 'nullable|array',
            'values.items.*.icon' => 'nullable|string|max:50',
            'values.items.*.title' => 'nullable|string|max:100',
            'values.items.*.description' => 'nullable|string|max:300',
            'journey.title' => 'nullable|string|max:200',
            'journey.items' => 'nullable|array',
            'journey.items.*.year' => 'nullable|string|max:10',
            'journey.items.*.title' => 'nullable|string|max:200',
            'journey.items.*.description' => 'nullable|string|max:500',
            'favorites.title' => 'nullable|string|max:200',
            'favorites.items' => 'nullable|array',
            'favorites.items.*.type' => 'nullable|string|max:100',
            'favorites.items.*.items' => 'nullable|string',
            'contact.title' => 'nullable|string|max:200',
            'contact.description' => 'nullable|string|max:500',
            'contact.social.instagram' => 'nullable|url|max:255',
            'contact.social.twitter' => 'nullable|url|max:255',
            'contact.social.pinterest' => 'nullable|url|max:255',
            'contact.social.email' => 'nullable|email|max:255',
            'settings.show_hero_images' => 'nullable|boolean',
            'settings.show_personal_info' => 'nullable|boolean',
            'settings.show_values' => 'nullable|boolean',
            'settings.show_journey' => 'nullable|boolean',
            'settings.show_favorites' => 'nullable|boolean',
            'settings.show_contact' => 'nullable|boolean',
            'remove_images.hero_bg' => 'nullable|boolean',
            'remove_images.profile' => 'nullable|boolean',
        ]);

        $existingSetting = Setting::where('key', 'about')->first();
        $existingData = $existingSetting ? json_decode($existingSetting->value, true) : getDefaultAboutData();

        $images = $existingData['images'] ?? getDefaultAboutData()['images'];

        if ($request->has('remove_images.hero_bg') && $request->input('remove_images.hero_bg') == '1') {
            $images['hero_bg'] = '';
        }

        if ($request->has('remove_images.profile') && $request->input('remove_images.profile') == '1') {
            $images['profile'] = '';
        }

        if ($request->hasFile('hero_bg_image')) {
            $images['hero_bg'] = uploadImage($request->file('hero_bg_image'), 'assets/about');
        }

        if ($request->hasFile('profile_image')) {
            $images['profile'] = uploadImage($request->file('profile_image'), 'assets/about');
        }

        $validated['images'] = $images;

        $booleanFields = [
            'settings.show_hero_images',
            'settings.show_personal_info',
            'settings.show_values',
            'settings.show_journey',
            'settings.show_favorites',
            'settings.show_contact'
        ];
        $validated = $this->handleBooleanFields($validated, $booleanFields);

        if (isset($validated['values']['items'])) {
            $validated['values']['items'] = array_filter($validated['values']['items'], function ($item) {
                return !empty($item['title']) || !empty($item['description']);
            });
        }

        if (isset($validated['journey']['items'])) {
            $validated['journey']['items'] = array_filter($validated['journey']['items'], function ($item) {
                return !empty($item['title']) || !empty($item['description']);
            });
        }

        if (isset($validated['favorites']['items'])) {
            $validated['favorites']['items'] = array_filter($validated['favorites']['items'], function ($item) {
                return !empty($item['type']) && !empty($item['items']);
            });
        }

        if (isset($validated['favorites']['items'])) {
            foreach ($validated['favorites']['items'] as &$favorite) {
                if (is_string($favorite['items'])) {
                    $favorite['items'] = array_filter(array_map('trim', explode("\n", $favorite['items'])));
                }
            }
        }

        $defaultData = getDefaultAboutData();
        $finalData = array_replace_recursive($defaultData, $validated);

        Setting::updateOrCreate(
            ['key' => 'about'],
            [
                'value' => json_encode($finalData, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT),
                'status' => $finalData['status']
            ]
        );

        return redirect()->back()->with('success', 'About page settings updated successfully.');
    }

    public function editContact()
    {
        $setting = Setting::where('key', 'contact')->first();

        $contactData = $setting ? json_decode($setting->value, true) : [];

        $contactData = array_merge(getDefaultContactData(), $contactData);

        return view('admin.settings.contact', [
            'contactData' => $contactData,
            'status' => $setting->status ?? 1
        ]);
    }

    public function updateContact(Request $request)
    {
        $validated = $request->validate([
            'status' => 'required|boolean',
            'hero.title' => 'required|string|max:200',
            'hero.description' => 'required|string|max:500',
            'hero.response_time' => 'nullable|string|max:200',
            'hero_bg_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'contactInfo.email' => 'required|email|max:255',
            'contactInfo.phone' => 'nullable|string|max:50',
            'contactInfo.address' => 'nullable|string|max:500',
            'contactInfo.emergency_contact' => 'nullable|string|max:200',
            'contactInfo.preferred_contact' => 'nullable|string|max:200',
            'contactInfo.social' => 'nullable|array',
            'contactInfo.social.*.platform' => 'required|string|max:50',
            'contactInfo.social.*.icon' => 'required|string|max:50',
            'contactInfo.social.*.url' => 'required|url|max:255',
            'contactInfo.social.*.handle' => 'nullable|string|max:100',
            'contactInfo.businessHours' => 'nullable|array',
            'contactInfo.businessHours.*.day' => 'required|string|max:100',
            'contactInfo.businessHours.*.hours' => 'required|string|max:100',
            'contactInfo.businessHours.*.status' => 'nullable|in:open,limited,closed',
            'contactInfo.faqs' => 'nullable|array',
            'contactInfo.faqs.*.question' => 'required|string|max:500',
            'contactInfo.faqs.*.answer' => 'required|string|max:1000',
            'map.title' => 'nullable|string|max:200',
            'map.latitude' => 'nullable|numeric',
            'map.longitude' => 'nullable|numeric',
            'map.zoom' => 'nullable|integer|min:1|max:18',
            'map.marker_title' => 'nullable|string|max:200',
            'map.marker_description' => 'nullable|string|max:500',
            'form.title' => 'nullable|string|max:200',
            'form.button_text' => 'nullable|string|max:50',
            'form.button_icon' => 'nullable|string|max:50',
            'form.success_message' => 'nullable|string|max:200',
            'form.enable_captcha' => 'nullable|boolean',
            'faq.title' => 'nullable|string|max:200',
            'settings.show_hero' => 'nullable|boolean',
            'settings.show_form' => 'nullable|boolean',
            'settings.show_contact_info' => 'nullable|boolean',
            'settings.show_social' => 'nullable|boolean',
            'settings.show_business_hours' => 'nullable|boolean',
            'settings.show_map' => 'nullable|boolean',
            'settings.show_faq' => 'nullable|boolean',
            'settings.enable_contact_form' => 'nullable|boolean',
            'remove_images.hero_bg' => 'nullable|boolean',
        ]);

        $existingSetting = Setting::where('key', 'contact')->first();
        $existingData = $existingSetting ? json_decode($existingSetting->value, true) : getDefaultContactData();

        $image = $existingData['hero']['hero_bg'] ?? '';

        if ($request->has('remove_images.hero_bg') && $request->input('remove_images.hero_bg') == '1') {
            $image = '';
        }

        if ($request->hasFile('hero_bg_image')) {
            $image = uploadImage($request->file('hero_bg_image'), 'assets/contact');
        }

        $validated['hero']['hero_bg'] = $image;

        $booleanFields = [
            'form.enable_captcha',
            'settings.show_hero',
            'settings.show_form',
            'settings.show_contact_info',
            'settings.show_social',
            'settings.show_business_hours',
            'settings.show_map',
            'settings.show_faq',
            'settings.enable_contact_form'
        ];
        $validated = $this->handleBooleanFields($validated, $booleanFields);

        if (isset($validated['contactInfo']['faqs'])) {
            $validated['contactInfo']['faqs'] = array_filter($validated['contactInfo']['faqs'], function ($item) {
                return !empty($item['question']) && !empty($item['answer']);
            });
        }

        $defaultData = getDefaultContactData();
        $finalData = array_replace_recursive($defaultData, $validated);

        Setting::updateOrCreate(
            ['key' => 'contact'],
            [
                'value' => json_encode($finalData, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT),
                'status' => $finalData['status']
            ]
        );

        return redirect()->back()->with('success', 'Contact page settings updated successfully.');
    }

    public function editPosts()
    {
        $setting = Setting::where('key', 'posts')->first();

        $postsPageData = $setting ? json_decode($setting->value, true) : [];

        $postsPageData = array_merge(getDefaultPostsPageData(), $postsPageData);

        return view('admin.settings.posts', [
            'postsPageData' => $postsPageData,
            'status' => $setting->status ?? 1
        ]);
    }

    public function updatePosts(Request $request)
    {
        $validated = $request->validate([
            'status' => 'required|boolean',
            'hero.title' => 'nullable|string|max:200',
            'hero.description' => 'nullable|string|max:500',
            'hero.search_placeholder' => 'nullable|string|max:100',
            'filter.show_search' => 'nullable|boolean',
            'filter.show_category_filter' => 'nullable|boolean',
            'filter.show_sort_options' => 'nullable|boolean',
            'filter.default_sort' => 'nullable|in:newest,oldest,popular,commented',
            'filter.default_category' => 'nullable|exists:categories,id',
            'layout.posts_per_page' => 'nullable|integer|min:1|max:50',
            'layout.show_sidebar' => 'nullable|boolean',
            'layout.grid_columns' => 'nullable|in:2,3,4',
            'sidebar.show_about_widget' => 'nullable|boolean',
            'sidebar.show_categories_widget' => 'nullable|boolean',
            'sidebar.show_popular_posts_widget' => 'nullable|boolean',
            'sidebar.show_newsletter_widget' => 'nullable|boolean',
            'sidebar.about_widget_title' => 'nullable|string|max:200',
            'sidebar.about_widget_content' => 'nullable|string|max:1000',
            'sidebar.popular_posts_title' => 'nullable|string|max:200',
            'sidebar.popular_posts_count' => 'nullable|integer|min:1|max:10',
            'empty_state.title' => 'nullable|string|max:200',
            'empty_state.message' => 'nullable|string|max:500',
            'pagination.show_pagination' => 'nullable|boolean',
            'pagination.type' => 'nullable|in:simple,numbered,both',
            'meta.meta_title' => 'nullable|string|max:200',
            'meta.meta_description' => 'nullable|string|max:500',
            'meta.meta_keywords' => 'nullable|string|max:500',
            'hero_bg_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'remove_images.hero_bg' => 'nullable|boolean',
        ]);

        $existingSetting = Setting::where('key', 'posts')->first();
        $existingData = $existingSetting ? json_decode($existingSetting->value, true) : getDefaultPostsPageData();

        $heroBgImage = $existingData['hero']['hero_bg'] ?? '';

        if ($request->has('remove_images.hero_bg') && $request->input('remove_images.hero_bg') == '1') {
            $heroBgImage = '';
        }

        if ($request->hasFile('hero_bg_image')) {
            $heroBgImage = uploadImage($request->file('hero_bg_image'), 'assets/posts-page');
        }

        $validated['hero']['hero_bg'] = $heroBgImage;
        $booleanFields = [
            'filter.show_search',
            'filter.show_category_filter',
            'filter.show_sort_options',
            'layout.show_sidebar',
            'sidebar.show_about_widget',
            'sidebar.show_categories_widget',
            'sidebar.show_popular_posts_widget',
            'sidebar.show_newsletter_widget',
            'pagination.show_pagination',
        ];

        foreach ($booleanFields as $field) {
            $keys = explode('.', $field);
            $lastKey = array_pop($keys);
            $array = &$validated;

            foreach ($keys as $key) {
                if (!isset($array[$key]) || !is_array($array[$key])) {
                    $array[$key] = [];
                }
                $array = &$array[$key];
            }

            if (!isset($array[$lastKey])) {
                $array[$lastKey] = 0;
            }
        }

        $defaultData = getDefaultPostsPageData();
        $finalData = array_replace_recursive($defaultData, $validated);

        Setting::updateOrCreate(
            ['key' => 'posts'],
            [
                'value' => json_encode($finalData, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT),
                'status' => $finalData['status']
            ]
        );

        return redirect()->back()->with('success', 'Posts page settings updated successfully.');
    }

    public function editGallery()
    {
        $setting = Setting::where('key', 'gallery')->first();

        $galleryData = $setting ? json_decode($setting->value, true) : [];

        $galleryData = array_merge(getDefaultGalleryData(), $galleryData);

        return view('admin.settings.gallery', [
            'galleryData' => $galleryData,
            'status' => $setting->status ?? 1
        ]);
    }

    public function updateGallery(Request $request)
    {
        $validated = $request->validate([
            'status' => 'required|boolean',
            'hero.title' => 'nullable|string|max:200',
            'hero.description' => 'nullable|string|max:500',
            'hero.show_stats' => 'nullable|boolean',
            'filter.show_sort_options' => 'nullable|boolean',
            'filter.default_sort' => 'nullable|in:newest,oldest,random,name',
            'layout.pictures_per_page' => 'nullable|integer|min:1|max:48',
            'layout.show_sidebar' => 'nullable|boolean',
            'layout.grid_columns' => 'nullable|in:2,3,4',
            'layout.masonry_enabled' => 'nullable|boolean',
            'sidebar.show_categories_widget' => 'nullable|boolean',
            'sidebar.show_recent_photos_widget' => 'nullable|boolean',
            'sidebar.show_tips_widget' => 'nullable|boolean',
            'sidebar.recent_photos_title' => 'nullable|string|max:200',
            'sidebar.recent_photos_count' => 'nullable|integer|min:1|max:12',
            'sidebar.tips_title' => 'nullable|string|max:200',
            'empty_state.title' => 'nullable|string|max:200',
            'empty_state.message' => 'nullable|string|max:500',
            'pagination.show_pagination' => 'nullable|boolean',
            'lightbox.enabled' => 'nullable|boolean',
            'lightbox.show_download_button' => 'nullable|boolean',
            'lightbox.show_fullscreen_button' => 'nullable|boolean',
            'lightbox.show_thumbnails' => 'nullable|boolean',
            'lightbox.keyboard_navigation' => 'nullable|boolean',
            'meta.meta_title' => 'nullable|string|max:200',
            'meta.meta_description' => 'nullable|string|max:500',
            'meta.meta_keywords' => 'nullable|string|max:500',
            'hero_bg_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'remove_images.hero_bg' => 'nullable|boolean',
        ]);

        $existingSetting = Setting::where('key', 'gallery')->first();
        $existingData = $existingSetting ? json_decode($existingSetting->value, true) : getDefaultGalleryData();

        $heroBgImage = $existingData['hero']['hero_bg'] ?? '';

        if ($request->has('remove_images.hero_bg') && $request->input('remove_images.hero_bg') == '1') {
            $heroBgImage = '';
        }

        if ($request->hasFile('hero_bg_image')) {
            $heroBgImage = uploadImage($request->file('hero_bg_image'), 'assets/gallery');
        }

        $validated['hero']['hero_bg'] = $heroBgImage;

        if (!isset($validated['hero'])) {
            $validated['hero'] = [];
        }
        if (!isset($validated['filter'])) {
            $validated['filter'] = [];
        }
        if (!isset($validated['layout'])) {
            $validated['layout'] = [];
        }
        if (!isset($validated['sidebar'])) {
            $validated['sidebar'] = [];
        }
        if (!isset($validated['empty_state'])) {
            $validated['empty_state'] = [];
        }
        if (!isset($validated['pagination'])) {
            $validated['pagination'] = [];
        }
        if (!isset($validated['lightbox'])) {
            $validated['lightbox'] = [];
        }
        if (!isset($validated['meta'])) {
            $validated['meta'] = [];
        }

        $booleanFields = [
            'hero.show_stats',
            'filter.show_sort_options',
            'layout.show_sidebar',
            'layout.masonry_enabled',
            'sidebar.show_categories_widget',
            'sidebar.show_recent_photos_widget',
            'sidebar.show_tips_widget',
            'pagination.show_pagination',
            'lightbox.enabled',
            'lightbox.show_download_button',
            'lightbox.show_fullscreen_button',
            'lightbox.show_thumbnails',
            'lightbox.keyboard_navigation',
        ];

        foreach ($booleanFields as $field) {
            $keys = explode('.', $field);
            $lastKey = array_pop($keys);
            $array = &$validated;

            foreach ($keys as $key) {
                if (!isset($array[$key]) || !is_array($array[$key])) {
                    $array[$key] = [];
                }
                $array = &$array[$key];
            }

            if (!isset($array[$lastKey])) {
                $array[$lastKey] = 0;
            } else {
                $array[$lastKey] = $array[$lastKey] ? 1 : 0;
            }
        }

        $defaultData = getDefaultGalleryData();
        $finalData = array_replace_recursive($defaultData, $validated);

        Setting::updateOrCreate(
            ['key' => 'gallery'],
            [
                'value' => json_encode($finalData, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT),
                'status' => $finalData['status']
            ]
        );

        return redirect()->back()->with('success', 'Gallery page settings updated successfully.');
    }

    public function editHomepage()
    {
        $setting = Setting::where('key', 'homepage')->first();

        $homepageData = $setting ? json_decode($setting->value, true) : [];

        $homepageData = array_merge(getDefaultHomepageData(), $homepageData);

        return view('admin.settings.homepage', [
            'homepageData' => $homepageData,
            'status' => $setting->status ?? 1
        ]);
    }

    public function updateHomepage(Request $request)
    {
        $validated = $request->validate([
            'status' => 'required|boolean',
            'hero.title' => 'nullable|string|max:200',
            'hero.subtitle' => 'nullable|string|max:500',
            'hero.button1_text' => 'nullable|string|max:50',
            'hero.button1_url' => 'nullable|string|max:255',
            'hero.button2_text' => 'nullable|string|max:50',
            'hero.button2_url' => 'nullable|string|max:255',
            'hero.show_world_icon' => 'nullable|boolean',
            'hero.enabled' => 'nullable|boolean',
            'carousel.enabled' => 'nullable|boolean',
            'carousel.interval' => 'nullable|integer|min:1000|max:10000',
            'carousel.show_indicators' => 'nullable|boolean',
            'carousel.show_controls' => 'nullable|boolean',
            'carousel.show_captions' => 'nullable|boolean',
            'carousel.height' => 'nullable|integer|min:300|max:800',
            'posts.enabled' => 'nullable|boolean',
            'posts.title' => 'nullable|string|max:200',
            'posts.subtitle' => 'nullable|string|max:500',
            'posts.show_button' => 'nullable|boolean',
            'posts.button_text' => 'nullable|string|max:50',
            'posts.posts_count' => 'nullable|integer|min:1|max:12',
            'posts.show_featured_image' => 'nullable|boolean',
            'posts.show_date' => 'nullable|boolean',
            'posts.show_category' => 'nullable|boolean',
            'posts.show_excerpt' => 'nullable|boolean',
            'posts.excerpt_length' => 'nullable|integer|min:50|max:500',
            'gallery.enabled' => 'nullable|boolean',
            'gallery.title' => 'nullable|string|max:200',
            'gallery.subtitle' => 'nullable|string|max:500',
            'gallery.show_button' => 'nullable|boolean',
            'gallery.button_text' => 'nullable|string|max:50',
            'gallery.images_count' => 'nullable|integer|min:1|max:12',
            'gallery.show_overlay' => 'nullable|boolean',
            'gallery.columns' => 'nullable|in:2,3,4,6',
            'about.enabled' => 'nullable|boolean',
            'about.title' => 'nullable|string|max:200',
            'about.content' => 'nullable|string|max:2000',
            'about.show_image' => 'nullable|boolean',
            'about.image_url' => 'nullable|string|max:255',
            'about.show_social_icons' => 'nullable|boolean',
            'about.social_links' => 'nullable|array',
            'about.social_links.*.platform' => 'nullable|string|max:50',
            'about.social_links.*.url' => 'nullable|url|max:255',
            'about.social_links.*.icon' => 'nullable|string|max:50',
            'meta.meta_title' => 'nullable|string|max:200',
            'meta.meta_description' => 'nullable|string|max:500',
            'meta.meta_keywords' => 'nullable|string|max:500',
            'hero_bg_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'remove_images.hero_bg' => 'nullable|boolean',
        ]);

        $existingSetting = Setting::where('key', 'homepage')->first();
        $existingData = $existingSetting ? json_decode($existingSetting->value, true) : getDefaultHomepageData();

        $heroBgImage = $existingData['hero']['hero_bg'] ?? '';
        $aboutImage = $existingData['about']['image'] ?? '';

        if ($request->has('remove_images.hero_bg') && $request->input('remove_images.hero_bg') == '1') {
            $heroBgImage = '';
        }

        if ($request->hasFile('hero_bg_image')) {
            $heroBgImage = uploadImage($request->file('hero_bg_image'), 'assets/homepage');
        }

        $validated['hero']['hero_bg'] = $heroBgImage;

        if ($request->hasFile('about_image')) {
            $aboutImage = uploadImage($request->file('about_image'), 'assets/homepage');
        }
        $validated['about']['image'] = $aboutImage;

        $sections = ['hero', 'carousel', 'posts', 'gallery', 'about', 'meta'];
        foreach ($sections as $section) {
            if (!isset($validated[$section])) {
                $validated[$section] = [];
            }
        }

        $booleanFields = [
            'hero.show_world_icon',
            'hero.enabled',
            'carousel.enabled',
            'carousel.show_indicators',
            'carousel.show_controls',
            'carousel.show_captions',
            'posts.enabled',
            'posts.show_button',
            'posts.show_featured_image',
            'posts.show_date',
            'posts.show_category',
            'posts.show_excerpt',
            'gallery.enabled',
            'gallery.show_button',
            'gallery.show_overlay',
            'about.enabled',
            'about.show_image',
            'about.show_social_icons',
        ];

        foreach ($booleanFields as $field) {
            $keys = explode('.', $field);
            $lastKey = array_pop($keys);
            $array = &$validated;

            foreach ($keys as $key) {
                if (!isset($array[$key]) || !is_array($array[$key])) {
                    $array[$key] = [];
                }
                $array = &$array[$key];
            }

            if (!isset($array[$lastKey])) {
                $array[$lastKey] = 0;
            } else {
                $array[$lastKey] = $array[$lastKey] ? 1 : 0;
            }
        }

        if (isset($validated['about']['social_links'])) {
            $validated['about']['social_links'] = array_filter(
                $validated['about']['social_links'],
                function ($link) {
                    return !empty($link['platform']) && !empty($link['url']);
                }
            );
        }

        $defaultData = getDefaultHomepageData();
        $finalData = array_replace_recursive($defaultData, $validated);

        Setting::updateOrCreate(
            ['key' => 'homepage'],
            [
                'value' => json_encode($finalData, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT),
                'status' => $finalData['status']
            ]
        );

        return redirect()->back()->with('success', 'Homepage settings updated successfully.');
    }

    public function editSections()
    {
        $menuSetting = Setting::where('key', 'menu')->first();
        $menuData = $menuSetting ? json_decode($menuSetting->value, true) : [];
        $menuData = array_merge(getDefaultMenuData(), $menuData);

        $footerSetting = Setting::where('key', 'footer')->first();
        $footer = json_decode($footerSetting->value, true) ?? getDefaultFooterData();
        $footer = array_merge(getDefaultFooterData(), $footer);

        foreach (['about', 'contact', 'newsletter', 'style'] as $key) {
            $footer[$key] = array_merge(getDefaultFooterData()[$key], $footer[$key] ?? []);
        };

        return view('admin.settings.sections', [
            'menu' => $menuData,
            'menu_status' => $menuSetting->status,
            'footer' => $footer,
            'footer_status' => $footerSetting->status,
            'social_platforms' => ['instagram', 'twitter', 'facebook', 'pinterest', 'youtube']
        ]);
    }

    public function updateMenu(Request $request)
    {
        $validated = $request->validate([
            'status' => 'required|boolean',
            'logo.type' => 'nullable|in:text,image,both',
            'logo.text' => 'nullable|string|max:100',
            'logo.text_color' => 'nullable|string|max:50',
            'logo.text_size' => 'nullable|integer|min:12|max:48',
            'navbar.bg_color' => 'nullable|string|max:50',
            'navbar.text_color' => 'nullable|string|max:50',
            'navbar.hover_color' => 'nullable|string|max:50',
            'navbar.active_color' => 'nullable|string|max:50',
            'navbar.height' => 'nullable|integer|min:50|max:120',
            'navbar.position' => 'nullable|in:fixed-top,static,sticky-top',
            'navbar.transparent' => 'nullable|boolean',
            'navbar.show_home' => 'nullable|boolean',
            'navbar.show_gallery' => 'nullable|boolean',
            'navbar.show_posts' => 'nullable|boolean',
            'navbar.show_about' => 'nullable|boolean',
            'navbar.show_contact' => 'nullable|boolean',
            'navbar.show_search' => 'nullable|boolean',
            'items' => 'nullable|array',
            'items.*.label' => 'required|string|max:50',
            'items.*.url' => 'required|string|max:255',
            'items.*.route' => 'nullable|string|max:100',
            'items.*.icon' => 'nullable|string|max:50',
            'items.*.enabled' => 'nullable|boolean',
            'items.*.new_tab' => 'nullable|boolean',
            'mobile.enabled' => 'nullable|boolean',
            'mobile.collapse_breakpoint' => 'nullable|in:sm,md,lg,xl',
            'mobile.show_icons' => 'nullable|boolean',
            'logo_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'remove_images.logo' => 'nullable|boolean',
        ]);

        $existingSetting = Setting::where('key', 'menu')->first();
        $existingData = $existingSetting ? json_decode($existingSetting->value, true) : getDefaultMenuData();

        $logoImage = $existingData['logo']['image'] ?? '';

        if ($request->has('remove_images.logo') && $request->input('remove_images.logo') == '1') {
            $logoImage = '';
        }

        if ($request->hasFile('logo_image')) {
            $logoImage = uploadImage($request->file('logo_image'), 'assets/menu');
        }

        $validated['logo']['image'] = $logoImage;

        if (!isset($validated['logo'])) {
            $validated['logo'] = [];
        }
        if (!isset($validated['navbar'])) {
            $validated['navbar'] = [];
        }
        if (!isset($validated['mobile'])) {
            $validated['mobile'] = [];
        }
        if (!isset($validated['items'])) {
            $validated['items'] = [];
        }

        $booleanFields = [
            'navbar.transparent',
            'navbar.show_home',
            'navbar.show_gallery',
            'navbar.show_posts',
            'navbar.show_about',
            'navbar.show_contact',
            'navbar.show_search',
            'mobile.enabled',
            'mobile.show_icons',
        ];

        foreach ($booleanFields as $field) {
            $keys = explode('.', $field);
            $lastKey = array_pop($keys);
            $array = &$validated;

            foreach ($keys as $key) {
                if (!isset($array[$key]) || !is_array($array[$key])) {
                    $array[$key] = [];
                }
                $array = &$array[$key];
            }

            if (!isset($array[$lastKey])) {
                $array[$lastKey] = 0;
            } else {
                $array[$lastKey] = $array[$lastKey] ? 1 : 0;
            }
        }

        $existingItems = $existingData['items'] ?? [];

        if (isset($validated['items'])) {
            $submittedItems = [];
            foreach ($validated['items'] as $item) {
                $key = $item['label'] . '|' . $item['url'];

                $item['enabled'] = isset($item['enabled']) ? ($item['enabled'] ? 1 : 0) : 0;
                $item['new_tab'] = isset($item['new_tab']) ? ($item['new_tab'] ? 1 : 0) : 0;

                $submittedItems[$key] = $item;
            }

            $mergedItems = [];

            foreach ($existingItems as $existingItem) {
                $key = $existingItem['label'] . '|' . $existingItem['url'];

                if (!isset($submittedItems[$key])) {
                    $mergedItems[$key] = $existingItem;
                }
            }

            foreach ($submittedItems as $key => $submittedItem) {
                $mergedItems[$key] = $submittedItem;
            }

            $validated['items'] = array_values($mergedItems);
        } else {
            $validated['items'] = $existingItems;
        }

        $defaultData = getDefaultMenuData();
        $finalData = array_replace_recursive($defaultData, $validated);

        Setting::updateOrCreate(
            ['key' => 'menu'],
            [
                'value' => json_encode($finalData, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT),
                'status' => $finalData['status']
            ]
        );

        return redirect()->back()->with('success', 'Menu settings updated successfully.');
    }


    public function updateFooter(Request $request)
    {
        $validator = Validator::make($request->all(), $this->getFooterValidationRules());

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $validator->validated();

        $booleanFields = ['footer.newsletter.enabled'];
        $data = $this->handleBooleanFields($data, $booleanFields);

        if (isset($data['footer']['quick_links'])) {
            $data['footer']['quick_links'] = array_values(array_filter(
                $data['footer']['quick_links'],
                fn($link) => !empty($link['label']) || !empty($link['url'])
            ));
        }

        $defaultData = getDefaultFooterData();
        $finalData = array_replace_recursive($defaultData, $data['footer'] ?? []);

        $setting = Setting::updateOrCreate(
            ['key' => 'footer'],
            [
                'value' => json_encode($finalData, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT),
                'status' => $request->status
            ]
        );

        return redirect()
            ->back()
            ->with('success', 'Footer settings updated successfully.');
    }

    private function getFooterValidationRules(): array
    {
        return [
            'status' => 'required|boolean',
            'footer.about.title' => 'nullable|string|max:255',
            'footer.about.description' => 'nullable|string|max:500',
            'footer.about.social.*' => 'nullable|url',
            'footer.quick_links.*.label' => 'required_with:footer.quick_links.*|string|max:50',
            'footer.quick_links.*.url' => 'nullable',
            'footer.contact.email' => 'nullable|email|max:255',
            'footer.contact.phone' => 'nullable|string|max:20',
            'footer.contact.address' => 'nullable|string|max:500',
            'footer.newsletter.enabled' => 'nullable|boolean',
            'footer.newsletter.placeholder' => 'nullable|string|max:100',
            'footer.newsletter.button_text' => 'nullable|string|max:50',
            'footer.style.bg_class' => 'nullable|string|max:100',
            'footer.style.text_class' => 'nullable|string|max:100',
            'footer.style.link_class' => 'nullable|string|max:100',
            'footer.style.icon_class' => 'nullable|string|max:100',
            'footer.copyright' => 'nullable|string|max:500',
            'footer.credit' => 'nullable|string|max:500'
        ];
    }
}
