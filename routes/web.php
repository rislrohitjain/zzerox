<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\VerificationController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\VerificationController as AdminVerificationController;
use App\Http\Controllers\Admin\SettingController as AdminSettingController;
use App\Http\Controllers\Admin\RoleUserController as AdminRoleUserController;
use App\Http\Controllers\Admin\BannerController as AdminBannerController;

/*
|--------------------------------------------------------------------------
| Web Routes - Zerox Pharmaceuticals Ltd
|--------------------------------------------------------------------------
*/

// Public Frontend Routes matching Zerox.com
Route::get('/', [FrontController::class, 'home'])->name('home');
Route::get('/about-us', [FrontController::class, 'about'])->name('about');
Route::get('/contact-us', [FrontController::class, 'contact'])->name('contact');
Route::post('/contact-us', [FrontController::class, 'submitContact'])->name('contact.submit');
Route::get('/lab-analysis', [FrontController::class, 'analysis'])->name('analysis');

// Catalog Routes
Route::get('/category/{slug}', [CatalogController::class, 'category'])->name('category.show');
Route::get('/product/{slug}', [CatalogController::class, 'product'])->name('products.show');

// Security Scratch Code Verification Route (Rate limited to 10 requests / min per IP)
Route::get('/authenticity', [VerificationController::class, 'index'])->name('authenticity');
Route::post('/authenticity/verify', [VerificationController::class, 'verify'])
    ->middleware('throttle:10,1')
    ->name('authenticity.verify');

// Live Search API Route
Route::get('/api/search', [SearchController::class, 'search'])->name('search');

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Admin Panel Routes (Protected by auth and role middleware: admin, operator1)
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin,operator1'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Products Management with Gallery Images
    Route::resource('products', AdminProductController::class)->except(['show']);
    Route::delete('products/images/{image}', [AdminProductController::class, 'destroyImage'])->name('products.images.destroy');

    // Categories Management
    Route::resource('categories', AdminCategoryController::class)->except(['show']);

    // Banners Management
    Route::resource('banners', AdminBannerController::class)->except(['show']);

    // Verifications Management
    Route::get('verifications', [AdminVerificationController::class, 'index'])->name('verifications.index');
    Route::get('verifications/create', [AdminVerificationController::class, 'create'])->name('verifications.create');
    Route::post('verifications', [AdminVerificationController::class, 'store'])->name('verifications.store');
    Route::delete('verifications/{verification}', [AdminVerificationController::class, 'destroy'])->name('verifications.destroy');

    // Settings & User Management (Admin role only)
    Route::middleware('role:admin')->group(function () {
        Route::get('settings', [AdminSettingController::class, 'index'])->name('settings.index');
        Route::post('settings', [AdminSettingController::class, 'update'])->name('settings.update');

        // Users & Roles Management
        Route::get('users', [AdminRoleUserController::class, 'index'])->name('users.index');
        Route::post('users', [AdminRoleUserController::class, 'store'])->name('users.store');
        Route::put('users/{user}/role', [AdminRoleUserController::class, 'updateRole'])->name('users.updateRole');
    });
});
