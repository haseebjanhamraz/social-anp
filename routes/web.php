<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\facebook\FacebookController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\SyncFacebookController;
use App\Http\Controllers\TestingController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/testing', [TestingController::class, 'index']);

Route::get('/auth/facebook', [FacebookController::class, 'redirectToFacebook']);
Route::get('/auth/facebook/callback', [FacebookController::class, 'handleFacebookCallback']);
Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard')->middleware('permission:view admin dashboard');

Route::prefix('dashboard')->group(function () {
    // Users Routes 
    Route::prefix('users')->group(function () {
        Route::get('/', [UsersController::class, 'index'])->name("dashboard.users.all");
        Route::get('/dashboard', [UsersController::class, 'dashboard'])->name('users.dashboard');
        Route::post('/register', [UsersController::class, 'register'])->name('user.register');
        Route::post('/update_status', [UsersController::class, 'updateStatus'])->name('user.updateStatus');
    });


    Route::prefix('admins')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name("dashboard.admins.all");
        Route::post('/create_admin', [AdminController::class, 'createAdmin'])->name('admin.createAdmin');
        Route::post('/update_admin', [AdminController::class, 'updateAdmin'])->name('admin.updateAdmin');
        Route::post('/delete_admin', [AdminController::class, 'deleteAdmin'])->name('admin.deleteAdmin');
    });
    // Posts Routes 
    Route::prefix('posts')->group(function () { // Use Route::group for nesting
        Route::get("/{user_id}", [PostsController::class, "index"])->name("dashboard.posts.all");
    });

    // Sync Routes 
    Route::prefix('sync')->group(function () { // Use Route::group for nesting
        Route::post("/facebook_sync", [SyncFacebookController::class, "syncFacebookPosts"])->name("sync.facebook.posts");
    });

    Route::get("/all", [PostsController::class, "facebookPosts"])->name("facebook.posts");
    Route::get("/user_posts", [PostsController::class, "userFacebookposts"])->name("user.facebook.posts");
    Route::get("/twitter", [PostsController::class, "twitterPosts"])->name("twitter.posts");
    Route::get("/instagram", [PostsController::class, "instagramPosts"])->name("instagram.posts");
});

Route::get("/sync", [PostsController::class, "syncPosts"])->name("dashboard.posts.sync");
Auth::routes(['register' => false]);
Route::get('/register_user', [UsersController::class, 'registerForm'])->name('user.register.form');
