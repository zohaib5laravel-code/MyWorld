<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\PictureController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingController;
use Illuminate\Support\Facades\Route;



Route::middleware('auth')->prefix('admin')->group(function () {

    Route::get('/dashboard',  [DashboardController::class, 'index'])->name('dashboard');
 
    Route::get('settings/footer', [SettingController::class, 'editFooter'])->name('settings.footer.edit');
    Route::post('settings/footer', [SettingController::class, 'updateFooter'])->name('settings.footer.update');
    Route::get('settings/about', [SettingController::class, 'editAbout'])->name('settings.about.edit');
    Route::post('settings/about', [SettingController::class, 'updateAbout'])->name('settings.about.update');
    Route::get('settings/contact', [SettingController::class, 'editContact'])->name('settings.contact.edit');
    Route::post('settings/contact', [SettingController::class, 'updateContact'])->name('settings.contact.update');
    Route::get('settings/posts', [SettingController::class, 'editPosts'])->name('settings.posts.edit');
    Route::post('settings/posts', [SettingController::class, 'updatePosts'])->name('settings.posts.update');
    Route::get('settings/gallery', [SettingController::class, 'editGallery'])->name('settings.gallery.edit');
    Route::post('settings/gallery', [SettingController::class, 'updateGallery'])->name('settings.gallery.update');
    Route::get('settings/homepage', [SettingController::class, 'editHomepage'])->name('settings.homepage.edit');
    Route::post('settings/homepage', [SettingController::class, 'updateHomepage'])->name('settings.homepage.update');
    Route::get('settings/menu', [SettingController::class, 'editMenu'])->name('settings.menu.edit');
    Route::post('settings/menu', [SettingController::class, 'updateMenu'])->name('settings.menu.update');
    Route::get('settings/sections', [SettingController::class, 'editSections'])
    ->name('settings.sections.edit');


    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    //pictures
    Route::get('pictures', [PictureController::class, 'index'])->name('pictures.index');
    Route::get('pictures/create', [PictureController::class, 'create'])->name('pictures.create');
    Route::post('pictures/store', [PictureController::class, 'store'])->name('pictures.store');
    Route::get('pictures/{id}', [PictureController::class, 'show'])->name('pictures.show');
    Route::get('pictures/{id}/edit', [PictureController::class, 'edit'])->name('pictures.edit');
    Route::patch('pictures/{id}/update', [PictureController::class, 'update'])->name('pictures.update');
    Route::delete('pictures/delete/{id}', [PictureController::class, 'delete'])->name('pictures.delete');

    //categories
    Route::get('categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('categories/store', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('categories/{id}', [CategoryController::class, 'show'])->name('categories.show');
    Route::get('categories/{id}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::patch('categories/{id}/update', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('categories/delete/{id}', [CategoryController::class, 'delete'])->name('categories.delete');

    //posts
    Route::get('posts', [PostController::class, 'index'])->name('posts.index');
    Route::get('posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('posts/store', [PostController::class, 'store'])->name('posts.store');
    Route::get('posts/{id}', [PostController::class, 'show'])->name('posts.show');
    Route::get('posts/{id}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::put('posts/{id}/update', [PostController::class, 'update'])->name('posts.update');
    Route::delete('posts/delete/{id}', [PostController::class, 'delete'])->name('posts.delete');

    //comments
    Route::get('comments', [CommentController::class, 'index'])->name('comments.index');
    Route::put('comments/update-status/{id}', [CommentController::class, 'updateStatus'])->name('comments.updateStatus');
    Route::delete('comments/delete/{id}', [CommentController::class, 'delete'])->name('comments.delete');

    //messages
    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/{id}', [MessageController::class, 'show'])->name('messages.show');
    Route::post('/messages/mark-read/{id}', [MessageController::class, 'markAsRead'])->name('messages.mark-read');
    Route::delete('/messages/delete/{id}', [MessageController::class, 'delete'])->name('messages.delete');
    Route::post('/messages/bulk-action', [MessageController::class, 'bulkAction'])->name('messages.bulk-action');
});

require __DIR__ . '/auth.php';



Route::get('/', [FrontendController::class, 'index'])->name('frontend.home');
Route::get('/gallery', [FrontendController::class, 'gallery'])->name('frontend.gallery');
Route::get('/about', [FrontendController::class, 'about'])->name('frontend.about');
Route::get('/contact', [FrontendController::class, 'contact'])->name('frontend.contact');
Route::post('/contact/send', [FrontendController::class, 'sendMessage'])->name('contact.send');
Route::get('/posts', [FrontendController::class, 'posts'])->name('frontend.posts');
Route::get('/{slug}', [FrontendController::class, 'post'])->name('frontend.post');
Route::post('/{post}/comment', [FrontendController::class, 'storeComment'])->name('frontend.comment.store');
