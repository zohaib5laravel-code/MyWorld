<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Comment;
use App\Models\ContactMessage;
use App\Models\Picture;
use App\Models\Post;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class FrontendController extends Controller
{
    public function index()
    {
        $homepageData = getHomepageData();
        if (!$homepageData['status']) {
            return view('frontend.maintenance');
        }

        $postsCount = $homepageData['posts']['posts_count'] ?? 3;
        $posts = Post::where('status', 'published')
            ->orderBy('id', 'DESC')
            ->limit($postsCount)
            ->get();

        $galleryImagesCount = $homepageData['gallery']['images_count'] ?? 6;
        $pictures = Picture::where('type', 'gallery')
            ->orderBy('created_at', 'DESC')
            ->limit($galleryImagesCount)
            ->get();

        $carouselImages = [];
        if ($homepageData['carousel']['enabled'] ?? 1) {
            $carouselImages = Picture::where('type', 'banner')
                ->orderBy('created_at', 'DESC')
                ->get();
        }

        $settings = [
            'status' => true,
            'hero' => [
                'enabled' => $homepageData['hero']['enabled'] ?? 1,
                'title' => $homepageData['hero']['title'] ?? 'Welcome to <span class="text-warning">My World</span>',
                'subtitle' => $homepageData['hero']['subtitle'] ?? 'This is my personal space where I share my journey through photos, stories, and experiences.',
                'button1_text' => $homepageData['hero']['button1_text'] ?? 'Explore Gallery',
                'button1_url' => $homepageData['hero']['button1_url'] ?? '#gallery',
                'button2_text' => $homepageData['hero']['button2_text'] ?? 'Read Posts',
                'button2_url' => $homepageData['hero']['button2_url'] ?? '#posts',
                'show_world_icon' => $homepageData['hero']['show_world_icon'] ?? 1,
                'hero_bg' => !empty($homepageData['hero']['hero_bg'])
                    ? asset('assets/homepage/' . $homepageData['hero']['hero_bg'])
                    : '',
            ],
            'carousel' => [
                'enabled' => $homepageData['carousel']['enabled'] ?? 1,
                'interval' => $homepageData['carousel']['interval'] ?? 5000,
                'show_indicators' => $homepageData['carousel']['show_indicators'] ?? 1,
                'show_controls' => $homepageData['carousel']['show_controls'] ?? 1,
                'show_captions' => $homepageData['carousel']['show_captions'] ?? 1,
                'height' => $homepageData['carousel']['height'] ?? 500,
            ],
            'posts' => [
                'enabled' => $homepageData['posts']['enabled'] ?? 1,
                'title' => $homepageData['posts']['title'] ?? 'Recent Posts',
                'subtitle' => $homepageData['posts']['subtitle'] ?? '',
                'show_button' => $homepageData['posts']['show_button'] ?? 1,
                'button_text' => $homepageData['posts']['button_text'] ?? 'View All Posts',
                'posts_count' => $postsCount,
                'show_featured_image' => $homepageData['posts']['show_featured_image'] ?? 1,
                'show_date' => $homepageData['posts']['show_date'] ?? 1,
                'show_category' => $homepageData['posts']['show_category'] ?? 1,
                'show_excerpt' => $homepageData['posts']['show_excerpt'] ?? 1,
                'excerpt_length' => $homepageData['posts']['excerpt_length'] ?? 150,
            ],
            'gallery' => [
                'enabled' => $homepageData['gallery']['enabled'] ?? 1,
                'title' => $homepageData['gallery']['title'] ?? 'Photo Gallery',
                'subtitle' => $homepageData['gallery']['subtitle'] ?? 'A collection of my favorite moments captured through the lens',
                'show_button' => $homepageData['gallery']['show_button'] ?? 1,
                'button_text' => $homepageData['gallery']['button_text'] ?? 'View Full Gallery',
                'images_count' => $galleryImagesCount,
                'show_overlay' => $homepageData['gallery']['show_overlay'] ?? 1,
                'columns' => $homepageData['gallery']['columns'] ?? 3,
            ],
            'about' => [
                'enabled' => $homepageData['about']['enabled'] ?? 1,
                'title' => $homepageData['about']['title'] ?? 'About My World',
                'content' => $homepageData['about']['content'] ?? 'Welcome to my personal corner of the internet.',
                'show_image' => $homepageData['about']['show_image'] ?? 1,
                'image' => !empty($homepageData['about']['image'])
                    ? asset('assets/homepage/' . $homepageData['about']['image'])
                    : 'https://images.unsplash.com/photo-1551632811-561732d1e306?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80',
                'show_social_icons' => $homepageData['about']['show_social_icons'] ?? 1,
                'social_links' => $homepageData['about']['social_links'] ?? [
                    ['platform' => 'instagram', 'url' => '#', 'icon' => 'fab fa-instagram'],
                    ['platform' => 'twitter', 'url' => '#', 'icon' => 'fab fa-twitter'],
                    ['platform' => 'facebook', 'url' => '#', 'icon' => 'fab fa-facebook'],
                    ['platform' => 'pinterest', 'url' => '#', 'icon' => 'fab fa-pinterest'],
                ],
            ],
            'meta' => [
                'meta_title' => $homepageData['meta']['meta_title'] ?? 'My World | Personal Blog & Gallery',
                'meta_description' => $homepageData['meta']['meta_description'] ?? 'Welcome to My World - a personal space.',
                'meta_keywords' => $homepageData['meta']['meta_keywords'] ?? 'personal blog, photo gallery, travel',
            ],
        ];

        $viewData = [
            'settings' => $settings,
            'posts' => $posts,
            'pictures' => $pictures,
            'carouselImages' => $carouselImages,
        ];

        $viewData = array_merge($viewData, [
            'heroEnabled' => $settings['hero']['enabled'],
            'carouselEnabled' => $settings['carousel']['enabled'],
            'carouselInterval' => $settings['carousel']['interval'],
            'showCarouselIndicators' => $settings['carousel']['show_indicators'],
            'showCarouselControls' => $settings['carousel']['show_controls'],
            'showCarouselCaptions' => $settings['carousel']['show_captions'],
            'carouselHeight' => $settings['carousel']['height'],
            'postsEnabled' => $settings['posts']['enabled'],
            'postsShowButton' => $settings['posts']['show_button'],
            'showFeaturedImage' => $settings['posts']['show_featured_image'],
            'showPostDate' => $settings['posts']['show_date'],
            'showPostCategory' => $settings['posts']['show_category'],
            'showExcerpt' => $settings['posts']['show_excerpt'],
            'galleryEnabled' => $settings['gallery']['enabled'],
            'galleryShowButton' => $settings['gallery']['show_button'],
            'showGalleryOverlay' => $settings['gallery']['show_overlay'],
            'galleryColumns' => $settings['gallery']['columns'],
            'aboutEnabled' => $settings['about']['enabled'],
            'showAboutImage' => $settings['about']['show_image'],
            'showSocialIcons' => $settings['about']['show_social_icons'],
        ]);

        return view('frontend.index', $viewData);
    }


    public function posts(Request $request)
    {
        $postsData = getPostsPageData();
        if (!$postsData['status']) {
            return view('frontend.maintenance');
        }

        $query = Post::query()->where('status', 'published');
        $showSearch = $postsData['filter']['show_search'] ?? true;
        if ($showSearch && $request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%")
                    ->orWhere('excerpt', 'like', "%{$search}%");
            });
        }

        $showCategoryFilter = $postsData['filter']['show_category_filter'] ?? true;
        if ($showCategoryFilter && $request->has('category') && $request->category) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('id', $request->category);
            });
        }

        $defaultSort = $postsData['filter']['default_sort'] ?? 'newest';
        $sort = $request->get('sort', $defaultSort);
        $showSortOptions = $postsData['filter']['show_sort_options'] ?? true;

        if ($showSortOptions) {
            switch ($sort) {
                case 'oldest':
                    $query->orderBy('created_at', 'asc');
                    break;
                case 'popular':
                    $query->orderBy('views', 'desc');
                    break;
                case 'commented':
                    $query->withCount('approvedComments')
                        ->orderBy('approved_comments_count', 'desc');
                    break;
                default:
                    $query->orderBy('created_at', 'desc');
                    break;
            }
        } else {
            switch ($defaultSort) {
                case 'oldest':
                    $query->orderBy('created_at', 'asc');
                    break;
                case 'popular':
                    $query->orderBy('views', 'desc');
                    break;
                case 'commented':
                    $query->withCount('approvedComments')
                        ->orderBy('approved_comments_count', 'desc');
                    break;
                default:
                    $query->orderBy('created_at', 'desc');
                    break;
            }
        }

        $postsPerPage = $postsData['layout']['posts_per_page'] ?? 8;
        $posts = $query->with(['category'])
            ->paginate($postsPerPage)
            ->withQueryString();

        $categories = Category::where('status', 1)->get();
        $popularPostsCount = $postsData['sidebar']['popular_posts_count'] ?? 5;
        $popularPosts = Post::where('status', 'published')
            ->orderBy('views', 'desc')
            ->limit($popularPostsCount)
            ->get();

        $settings = [
            'status' => true,
            'hero' => [
                'title' => $postsData['hero']['title'] ?? 'My Stories & Thoughts',
                'description' => $postsData['hero']['description'] ?? 'Explore my journey through personal stories, reflections, and experiences shared from my world.',
                'search_placeholder' => $postsData['hero']['search_placeholder'] ?? 'Search posts...',
                'hero_bg' => !empty($postsData['hero']['hero_bg'])
                    ? asset('assets/posts-page/' . $postsData['hero']['hero_bg'])
                    : 'https://images.unsplash.com/photo-1519681393784-d120267933ba?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
            ],
            'filter' => [
                'show_search' => $showSearch,
                'show_category_filter' => $showCategoryFilter,
                'show_sort_options' => $showSortOptions,
                'default_sort' => $defaultSort,
                'current_sort' => $sort,
                'default_category' => $postsData['filter']['default_category'] ?? null,
                'current_category' => $request->get('category'),
                'current_search' => $request->get('search'),
            ],
            'layout' => [
                'show_sidebar' => $postsData['layout']['show_sidebar'] ?? true,
                'grid_columns' => $postsData['layout']['grid_columns'] ?? 2,
            ],
            'sidebar' => [
                'show_about_widget' => $postsData['sidebar']['show_about_widget'] ?? true,
                'show_categories_widget' => $postsData['sidebar']['show_categories_widget'] ?? true,
                'show_popular_posts_widget' => $postsData['sidebar']['show_popular_posts_widget'] ?? true,
                'show_newsletter_widget' => $postsData['sidebar']['show_newsletter_widget'] ?? true,
                'about_widget_title' => $postsData['sidebar']['about_widget_title'] ?? 'About This Blog',
                'about_widget_content' => $postsData['sidebar']['about_widget_content'] ?? 'Welcome to my personal blog.',
                'popular_posts_title' => $postsData['sidebar']['popular_posts_title'] ?? 'Popular Posts',
                'popular_posts_count' => $popularPostsCount,
            ],
            'empty_state' => [
                'title' => $postsData['empty_state']['title'] ?? 'No Posts Found',
                'message' => $postsData['empty_state']['message'] ?? 'Try adjusting your search or filter to find what you\'re looking for.',
            ],
            'pagination' => [
                'show_pagination' => $postsData['pagination']['show_pagination'] ?? true,
                'type' => $postsData['pagination']['type'] ?? 'both',
            ],
            'meta' => [
                'meta_title' => $postsData['meta']['meta_title'] ?? 'My Stories & Thoughts | Blog',
                'meta_description' => $postsData['meta']['meta_description'] ?? 'Explore personal stories.',
                'meta_keywords' => $postsData['meta']['meta_keywords'] ?? 'blog, stories, thoughts',
            ],
            'post_settings' => [
                'show_featured_image' => $postsData['posts']['show_featured_image'] ?? true,
                'show_date' => $postsData['posts']['show_date'] ?? true,
                'show_category' => $postsData['posts']['show_category'] ?? true,
                'show_excerpt' => $postsData['posts']['show_excerpt'] ?? true,
                'excerpt_length' => $postsData['posts']['excerpt_length'] ?? 150,
            ],
        ];

        $viewData = [
            'settings' => $settings,
            'posts' => $posts,
            'categories' => $categories,
            'popularPosts' => $popularPosts,
        ];

        $viewData = array_merge($viewData, [
            'status' => $settings['status'],
            'showSidebar' => $settings['layout']['show_sidebar'],
            'showSearch' => $settings['filter']['show_search'],
            'showCategoryFilter' => $settings['filter']['show_category_filter'],
            'showSortOptions' => $settings['filter']['show_sort_options'],
            'defaultSort' => $settings['filter']['default_sort'],
            'gridColumns' => $settings['layout']['grid_columns'],
            'showAboutWidget' => $settings['sidebar']['show_about_widget'],
            'showCategoriesWidget' => $settings['sidebar']['show_categories_widget'],
            'showPopularPostsWidget' => $settings['sidebar']['show_popular_posts_widget'],
            'showNewsletterWidget' => $settings['sidebar']['show_newsletter_widget'],
            'showPagination' => $settings['pagination']['show_pagination'],
            'paginationType' => $settings['pagination']['type'],
            'showFeaturedImage' => $settings['post_settings']['show_featured_image'],
            'showPostDate' => $settings['post_settings']['show_date'],
            'showPostCategory' => $settings['post_settings']['show_category'],
            'showExcerpt' => $settings['post_settings']['show_excerpt'],
            'excerptLength' => $settings['post_settings']['excerpt_length'],
        ]);

        return view('frontend.posts', $viewData);
    }


    public function post($slug)
    {
        $post = Post::where('slug', $slug)->first();
        $categories = Category::where('status', 1)->get();
        $relatedPosts = Post::where('category_id', $post->category_id)
            ->where('id', '!=', $post->id)
            ->where('status', 'published')
            ->inRandomOrder()
            ->limit(3)
            ->get();


        return view('frontend.post', compact('post', 'categories', 'relatedPosts'));
    }

    public function storeComment(Request $request, Post $post)
    {

        $comment = new Comment();
        $comment->post_id = $post->id;
        $comment->name = $request->input('name');
        //$comment->email = $request->input('email');
        $comment->comment = $request->input('comment');
        $comment->ip_address  = $request->ip();
        $comment->status = 0;
        $comment->save();


        return redirect()
            ->back()
            ->with('success', 'Your comment has been submitted and is awaiting moderation.');
    }

    public function gallery(Request $request)
    {
        $galleryData = getGalleryData();
        if (!$galleryData['status']) {
            return view('frontend.maintenance');
        }

        $query = Picture::where('type', 'gallery');
        $defaultSort = $galleryData['filter']['default_sort'] ?? 'newest';
        $sort = $request->get('sort', $defaultSort);

        switch ($sort) {
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'random':
                $query->inRandomOrder();
                break;
            case 'name':
                $query->orderBy('title', 'asc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        $picturesPerPage = $galleryData['layout']['pictures_per_page'] ?? 12;
        $pictures = $query->paginate($picturesPerPage)
            ->withQueryString();
        $categories = Category::where('status', 1)->get();
        $recentPhotosCount = $galleryData['sidebar']['recent_photos_count'] ?? 8;

        $recentPictures = Picture::where('type', 'gallery')
            ->orderBy('created_at', 'desc')
            ->limit($recentPhotosCount)
            ->get();

        $settings = [
            'status' => true,
            'hero' => [
                'title' => $galleryData['hero']['title'] ?? 'My Visual Journey',
                'description' => $galleryData['hero']['description'] ?? 'Explore my world through photographs captured in moments of wonder, adventure, and quiet reflection.',
                'show_stats' => $galleryData['hero']['show_stats'] ?? 1,
                'hero_bg' => !empty($galleryData['hero']['hero_bg'])
                    ? asset('assets/gallery/' . $galleryData['hero']['hero_bg'])
                    : 'https://images.unsplash.com/photo-1519681393784-d120267933ba?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80',
            ],
            'filter' => [
                'show_sort_options' => $galleryData['filter']['show_sort_options'] ?? 1,
                'default_sort' => $defaultSort,
                'current_sort' => $sort,
            ],
            'layout' => [
                'show_sidebar' => $galleryData['layout']['show_sidebar'] ?? 1,
                'grid_columns' => $galleryData['layout']['grid_columns'] ?? 3,
                'masonry_enabled' => $galleryData['layout']['masonry_enabled'] ?? 1,
            ],
            'sidebar' => [
                'show_categories_widget' => $galleryData['sidebar']['show_categories_widget'] ?? 1,
                'show_recent_photos_widget' => $galleryData['sidebar']['show_recent_photos_widget'] ?? 1,
                'show_tips_widget' => $galleryData['sidebar']['show_tips_widget'] ?? 1,
                'recent_photos_title' => $galleryData['sidebar']['recent_photos_title'] ?? 'Recent Photos',
                'tips_title' => $galleryData['sidebar']['tips_title'] ?? 'Gallery Tips',
                'recent_photos_count' => $recentPhotosCount,
            ],
            'pagination' => [
                'show_pagination' => $galleryData['pagination']['show_pagination'] ?? 1,
            ],
            'lightbox' => [
                'enabled' => $galleryData['lightbox']['enabled'] ?? 1,
                'show_download_button' => $galleryData['lightbox']['show_download_button'] ?? 1,
                'show_fullscreen_button' => $galleryData['lightbox']['show_fullscreen_button'] ?? 1,
                'show_thumbnails' => $galleryData['lightbox']['show_thumbnails'] ?? 1,
                'keyboard_navigation' => $galleryData['lightbox']['keyboard_navigation'] ?? 1,
            ],
            'empty_state' => [
                'title' => $galleryData['empty_state']['title'] ?? 'No Photos Found',
                'message' => $galleryData['empty_state']['message'] ?? 'Try adjusting your search or filter to find what you\'re looking for.',
            ],
            'stats' => [
                'total_photos' => Picture::where('type', 'gallery')->count(),
                'recent_uploads' => $recentPictures->count(),
            ],
        ];

        $viewData = [
            'settings' => $settings,
            'pictures' => $pictures,
            'categories' => $categories,
            'recentPictures' => $recentPictures,
        ];

        $viewData = array_merge($viewData, [
            'status' => $settings['status'],
            'showStats' => $settings['hero']['show_stats'],
            'showSidebar' => $settings['layout']['show_sidebar'],
            'showSortOptions' => $settings['filter']['show_sort_options'],
            'defaultSort' => $settings['filter']['default_sort'],
            'gridColumns' => $settings['layout']['grid_columns'],
            'masonryEnabled' => $settings['layout']['masonry_enabled'],
            'showCategoriesWidget' => $settings['sidebar']['show_categories_widget'],
            'showRecentPhotosWidget' => $settings['sidebar']['show_recent_photos_widget'],
            'showTipsWidget' => $settings['sidebar']['show_tips_widget'],
            'showPagination' => $settings['pagination']['show_pagination'],
            'lightboxEnabled' => $settings['lightbox']['enabled'],
            'showDownloadBtn' => $settings['lightbox']['show_download_button'],
            'showFullscreenBtn' => $settings['lightbox']['show_fullscreen_button'],
            'showThumbnails' => $settings['lightbox']['show_thumbnails'],
            'keyboardNav' => $settings['lightbox']['keyboard_navigation'],
        ]);

        return view('frontend.gallery', $viewData);
    }

    public function about()
    {
        $aboutData = getAboutData();
        if (!$aboutData['status']) {
            return view('frontend.maintenance');
        }
        $personalInfo = $aboutData['personalInfo'] ?? [];
        $stats = $aboutData['stats'] ?? [];

        $journey = $aboutData['journey'] ?? [];
        $values = $aboutData['values'] ?? [];
        $favorites = $aboutData['favorites'] ?? [];
        $settings = $aboutData['settings'] ?? [];
        $status = $aboutData['status'] ?? [];

        return view('frontend.about', compact(
            'aboutData',
            'status',
            'personalInfo',
            'stats',
            'journey',
            'values',
            'favorites',
            'settings'
        ));
    }

    public function contact()
    {
        $contactData = getContactData();

        if (!$contactData['status']) {
            return view('frontend.maintenance');
        }

        return view('frontend.contact', [
            'contactInfo' => $contactData['contactInfo'] ?? [],
            'hero' => $contactData['hero'] ?? [],
            'map' => $contactData['map'] ?? [],
            'form' => $contactData['form'] ?? [],
            'faq' => $contactData['faq'] ?? [],
            'settings' => $contactData['settings'] ?? [],
            'status' => $contactData['status'] ?? 0,
        ]);
    }

    public function sendMessage(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|min:10|max:2000',
        ];

        $messages = [
            'name.required' => 'Please enter your name.',
            'email.required' => 'Please enter your email address.',
            'email.email' => 'Please enter a valid email address.',
            'subject.required' => 'Please enter a subject.',
            'message.required' => 'Please enter your message.',
            'message.min' => 'Your message should be at least 10 characters.',
            'message.max' => 'Your message should not exceed 2000 characters.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect()
                ->route('frontend.contact')
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Please fix the errors below.');
        }

        try {
            if (class_exists(ContactMessage::class)) {
                ContactMessage::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'subject' => $request->subject,
                    'message' => $request->message,
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->header('User-Agent'),
                    'status' => 'unread',
                ]);
            }

            ///$this->sendEmailNotification($request->all());
            Log::info('New contact form submission received:', [
                'name' => $request->name,
                'email' => $request->email,
                'subject' => $request->subject,
                'ip' => $request->ip(),
            ]);
            return redirect()
                ->route('frontend.contact')
                ->with('success', 'Thank you for your message! I\'ll get back to you within 24-48 hours.');
        } catch (\Exception $e) {
            Log::error('Contact form submission failed:', [
                'error' => $e->getMessage(),
                'data' => $request->except('message'),
            ]);
            return redirect()
                ->route('frontend.contact')
                ->with('error', 'Something went wrong. Please try again later.')
                ->withInput();
        }
    }
}
