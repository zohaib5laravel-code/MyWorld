<?php

namespace App\Http\Controllers;
use App\Models\Post;
use App\Models\Category;
use App\Models\Picture;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalPosts = Post::count();
        $totalViews = Post::sum('views');
        $totalCategories = Category::where('status', 1)->count();
        $totalPictures = Picture::count();
        
        $publishedPosts = Post::where('status', 'published')->count();
        $draftPosts = Post::where('status', 'draft')->count();
        $archivedPosts = Post::where('status', 'archived')->count();
        
        $publishedPercentage = $totalPosts > 0 ? ($publishedPosts / $totalPosts) * 100 : 0;
        $draftPercentage = $totalPosts > 0 ? ($draftPosts / $totalPosts) * 100 : 0;
        $archivedPercentage = $totalPosts > 0 ? ($archivedPosts / $totalPosts) * 100 : 0;
        
        $dailyViews = Post::whereDate('created_at', Carbon::today())->sum('views');
        
        $picturesByType = [
            'gallery' => Picture::where('type', 'gallery')->count(),
            'banner' => Picture::where('type', 'banner')->count(),
       ];
        
        $recentPosts = Post::with('category')->latest()->take(5)->get();
        $popularPosts = Post::with('category')->orderBy('views', 'desc')->take(5)->get();
        $recentPictures = Picture::latest()->take(6)->get();
        
         $postsGrowth = $totalPosts > 10 ? rand(5, 15) : rand(20, 50);
        
    
        
        $stats = [
            'total_posts' => $totalPosts,
            'total_views' => $totalViews,
            'total_categories' => $totalCategories,
            'total_pictures' => $totalPictures,
            'published_posts' => $publishedPosts,
            'draft_posts' => $draftPosts,
            'archived_posts' => $archivedPosts,
            'published_percentage' => round($publishedPercentage),
            'draft_percentage' => round($draftPercentage),
            'archived_percentage' => round($archivedPercentage),
            'daily_views' => $dailyViews,
            'posts_growth' => $postsGrowth,
            'active_categories' => $totalCategories,
            'pictures_by_type' => $picturesByType,
        ];
        
        return view('admin.dashboard', compact(
            'stats',
            'recentPosts',
            'popularPosts',
            'recentPictures',
        ));
    }
}