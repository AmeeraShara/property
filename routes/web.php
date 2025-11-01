<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LandController;
use App\Http\Controllers\RentController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\DestricController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\ContactusController;
use App\Http\Controllers\SuperAdmin\SuperAdminController;
use App\Http\Controllers\WantedController;

use Illuminate\Support\Facades\Route;

//  PUBLIC ROUTES (no login required)
Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('register', [RegisteredUserController::class, 'store']);

Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('login', [AuthenticatedSessionController::class, 'store']);

Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');
Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
Route::post('reset-password', [NewPasswordController::class, 'store'])->name('password.store');


// SALES ROUTES - Move these before dashboard for better organization
Route::get('/sales', [SalesController::class, 'index'])->name('sales.index');
Route::post('/sales/search', [SalesController::class, 'search'])->name('sales.search');
Route::get('/sales/home-details/{id}', [SalesController::class, 'homeDetails'])->name('sales.home-details');
Route::get('/sales/land-details/{id}', [SalesController::class, 'landDetails'])->name('sales.land-details');
Route::get('/property/details/{id}', [SalesController::class, 'propertyDetails'])->name('sales.property-details');
Route::post('/sales/contact-inquiry', [SalesController::class, 'submitInquiry'])->name('sales.contact-inquiry');
Route::post('/submit-inquiry', [SalesController::class, 'submitInquiry'])->name('sales.submit-inquiry');
Route::post('/sales/save-property', [SalesController::class, 'saveProperty'])->name('sales.save-property');
Route::get('/sales/favorites', [SalesController::class, 'favorites'])->name('sales.favorites');


// Favorite routes
Route::post('/favorites/toggle', [FavoriteController::class, 'toggleFavorite'])->name('favorites.toggle');
Route::get('/favorites', [FavoriteController::class, 'getFavorites'])->name('favorites.index');

//wanted
Route::get('/wanted', [WantedController::class, 'index'])->name('wanted.index');
Route::post('/wanted', [WantedController::class, 'store'])->name('wanted.store');
Route::get('/wanted/load-more', [WantedController::class, 'loadMore'])->name('wanted.load-more');

//contactus
Route::get('/contactus', [ContactusController::class, 'index'])->name('contactus.index');
Route::post('/contact/send', [ContactusController::class, 'send'])->name('contact.send');
Route::get('/superadmin/contact-messages', [ContactusController::class, 'showMessages'])->name('contact.messages');

// Rent Routes
Route::get('/rent', function () {
    return view('rent.index');
})->name('rent.index');

// Dashboard route
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
Route::get('/dashboard/hot-deal', [DashboardController::class, 'hotDeal'])->name('dashboard.hot-deal');

//destric
Route::get('/destric', [DestricController::class, 'index'])->name('destric.index');
Route::get('/dashboard/trending', [DashboardController::class, 'trending'])->name('dashboard.trending');
// Add this to your web.php routes
Route::get('/post-debug/{id}', function($id) {
    $post = \App\Models\Post::find($id);
    
    if (!$post) {
        return "Post not found";
    }
    
    echo "<h1>Debug Post: {$post->id} - {$post->ad_title}</h1>";
    
    echo "<h3>Raw images data:</h3>";
    echo "<pre>";
    var_dump($post->images);
    echo "</pre>";
    
    echo "<h3>Images array attribute:</h3>";
    echo "<pre>";
    var_dump($post->images_array);
    echo "</pre>";
    
    echo "<h3>First image URL:</h3>";
    echo $post->first_image;
    
    echo "<h3>Storage files in post-images:</h3>";
    $files = \Illuminate\Support\Facades\Storage::disk('public')->allFiles('post-images');
    echo "<pre>";
    var_dump($files);
    echo "</pre>";
    
    die();
});

Route::get('/land', [LandController::class, 'index'])->name('land.index');
// Rent Routes
Route::get('/rent', [RentController::class, 'index'])->name('rent.index');



// Auto calculation routes
Route::get('/auto-hot-deals', [DashboardController::class, 'autoHotDeals'])->name('dashboard.auto-hot-deals');
Route::get('/auto-trending', [DashboardController::class, 'autoTrending'])->name('dashboard.auto-trending');
Route::get('/dynamic-status', [DashboardController::class, 'dynamicStatus'])->name('dashboard.dynamic-status');

Route::post('/newsletter/subscribe', [NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');
Route::post('/newsletter/unsubscribe', [NewsletterController::class, 'unsubscribe'])->name('newsletter.unsubscribe');




// POST ROUTES
Route::prefix('posts')->group(function () {
    // Step 1 - Initial post creation
    Route::get('/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('/store-step1', [PostController::class, 'store'])->name('posts.store');

    // Step 2 - Property type specific forms (GET routes)
    Route::get('/housepost', [PostController::class, 'housepost'])->name('posts.housepost');
    Route::get('/apartment-post', [PostController::class, 'apartmentPost'])->name('posts.apartment-post');
    Route::get('/land-post', [PostController::class, 'landPost'])->name('posts.land-post');
    Route::get('/commercial-post', [PostController::class, 'commercialPost'])->name('posts.commercial-post');

    // Step 2 - Store methods (POST routes)
    Route::post('/store-housepost', [PostController::class, 'storehousepost'])->name('posts.storehousepost');
    Route::post('/store-apartment', [PostController::class, 'storeApartment'])->name('posts.store.apartment');
    Route::post('/store-land', [PostController::class, 'storeLand'])->name('posts.land.store');
    Route::post('/store-commercial', [PostController::class, 'storeCommercial'])->name('posts.commercial.store');

    // Step 3 - Final step
    Route::get('/post3', [PostController::class, 'ThirdPost'])->name('posts.post3');
    Route::post('/store-final', [PostController::class, 'storeFinal'])->name('posts.final.store');
});

// Regular CRUD routes (exclude create and store as we have custom ones)
Route::resource('posts', PostController::class)->except(['create', 'store']);

// Other post routes
Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
Route::get('/posts/{id}', [PostController::class, 'show'])->name('posts.show');
Route::get('/posts/{id}/edit', [PostController::class, 'edit'])->name('posts.edit');
Route::put('/posts/{id}', [PostController::class, 'update'])->name('posts.update');
Route::delete('/posts/{id}', [PostController::class, 'destroy'])->name('posts.destroy');

// 🟣 PROTECTED ROUTES (only for logged-in users)
Route::middleware('auth')->group(function () {
    Route::get('verify-email', EmailVerificationPromptController::class)->name('verification.notice');
    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttled'])
        ->name('verification.verify');
    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

  
   Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');
    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    // Profile route: Shows user details (e.g., name, role, etc.)
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'show'])->name('profile');
    
    // Optional: Update profile (if you want edit functionality later)
    Route::put('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');

});


 
// Super Admin Routes
Route::prefix('superadmin')->group(function () {

    // Dashboard
    Route::get('/dashboard', [SuperAdminController::class, 'dashboard'])->name('superadmin.dashboard'); 

    // View posts
    Route::get('/posts', [SuperAdminController::class, 'posts'])->name('superadmin.posts');
    Route::get('/posts/{id}', [SuperAdminController::class, 'show'])->name('superadmin.show');
    Route::get('/posts/{id}/edit', [SuperAdminController::class, 'edit'])->name('superadmin.edit');
    Route::post('/posts/{id}/update', [SuperAdminController::class, 'update'])->name('superadmin.update');
    Route::delete('/posts/{id}', [SuperAdminController::class, 'destroy'])->name('superadmin.delete');


    // Advertisers
    Route::get('/advertisers', [SuperAdminController::class, 'advertisers'])->name('superadmin.advertisers');

    // Inquiries
    Route::get('/inquiries', [SuperAdminController::class, 'inquiries'])->name('superadmin.inquiries');

    // Newsletter Subscribers
    Route::get('/subscribers', [SuperAdminController::class, 'subscribers'])->name('superadmin.subscribers');
});

    // Users
Route::get('/superadmin/users', [SuperAdminController::class, 'users'])->name('superadmin.users');
Route::get('/superadmin/users/{id}', [SuperAdminController::class, 'showUser'])->name('superadmin.users.show');
Route::get('/superadmin/users/{id}/edit', [SuperAdminController::class, 'editUser'])->name('superadmin.users.edit');
Route::post('/superadmin/users/{id}/update', [SuperAdminController::class, 'updateUser'])->name('superadmin.users.update');
Route::delete('/superadmin/users/{id}', [SuperAdminController::class, 'destroyUser'])->name('superadmin.users.destroy');

// Properties
Route::get('/superadmin/properties', [SuperAdminController::class, 'properties'])->name('superadmin.properties');
Route::get('/superadmin/properties/{id}', [SuperAdminController::class, 'showProperty'])->name('superadmin.properties.show');
Route::get('/superadmin/properties/{id}/edit', [SuperAdminController::class, 'editProperty'])->name('superadmin.properties.edit');
Route::post('/superadmin/properties/{id}/update', [SuperAdminController::class, 'updateProperty'])->name('superadmin.properties.update');
Route::delete('/superadmin/properties/{id}', [SuperAdminController::class, 'destroyProperty'])->name('superadmin.properties.delete');

Route::prefix('superadmin')->name('superadmin.')->group(function() {
    Route::get('/subscribers', [SuperAdminController::class, 'subscribers'])->name('subscribers');
    Route::get('/subscribers/{id}', [SuperAdminController::class, 'showSubscriber'])->name('subscribers.show');
    Route::get('/subscribers/{id}/edit', [SuperAdminController::class, 'editSubscriber'])->name('subscribers.edit');
    Route::patch('/subscribers/{id}', [SuperAdminController::class, 'updateSubscriber'])->name('subscribers.update');
    Route::delete('/subscribers/{id}', [SuperAdminController::class, 'destroySubscriber'])->name('subscribers.destroy');
    Route::patch('/subscribers/{id}/toggle', [SuperAdminController::class, 'toggleSubscriberStatus'])->name('subscribers.toggle');
});


Route::prefix('superadmin')->name('superadmin.')->group(function () {
    Route::get('/advertisers', [SuperAdminController::class, 'advertisers'])->name('advertisers');
    Route::get('/advertisers/create', [SuperAdminController::class, 'createAdvertiser'])->name('advertisers.create');
    Route::patch('/advertisers/store', [SuperAdminController::class, 'storeAdvertiser'])->name('advertisers.store');
    Route::get('/advertisers/edit/{id}', [SuperAdminController::class, 'editAdvertiser'])->name('advertisers.edit');
Route::patch('/advertisers/update/{id}', [SuperAdminController::class, 'updateAdvertiser'])->name('advertisers.update');
    Route::delete('/advertisers/delete/{id}', [SuperAdminController::class, 'deleteAdvertiser'])->name('advertisers.delete');
});

Route::prefix('superadmin')->name('superadmin.')->group(function () {
    Route::resource('premium', \App\Http\Controllers\SuperAdmin\PremiumPackageController::class);
});
