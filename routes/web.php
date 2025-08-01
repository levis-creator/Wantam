<?php

use Livewire\Volt\Volt;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file defines the web routes for a Laravel 12 application using Livewire
| Volt components. Routes point to Volt pages in resources\views\livewire\pages
| for static pages created via batch script (about, contact, faq, etc.) and
| app/Livewire/Pages for other components (catalogue, product, etc.). Routes are
| simplified to support core e-commerce functionality (home, about, contact,
| catalogue, etc.). All routes are SEO-optimized with named routes. No data
| handling (e.g., Category or Product models) is included. Routes integrate with
| header components and use custom CSS classes from public/css/app.css or Filament
| styles. Authentication routes are included from auth.php.
|
*/

// Home route (default without locale)
Volt::route('/', 'pages.home')->name('home');

// Static pages for core e-commerce functionality
Volt::route('/about', 'pages.about')->name('about'); // About page
Volt::route('/contact', 'pages.contact')->name('contact'); // Contact page
Volt::route('/faq', 'pages.faq')->name('faq'); // FAQs page
Volt::route('/terms', 'pages.terms')->name('terms'); // Terms page
Volt::route('/privacy', 'pages.privacy')->name('privacy'); // Privacy page
Volt::route('/how-to-shop', 'pages.how-to-shop')->name('how-to-shop'); // How to shop page
Volt::route('/payment-methods', 'pages.payment-methods')->name('payment-methods'); // Payment methods page
Volt::route('/money-back', 'pages.money-back')->name('money-back'); // Money back page
Volt::route('/returns', 'pages.returns')->name('returns'); // Returns page
Volt::route('/shipping', 'pages.shipping')->name('shipping'); // Shipping page
Volt::route('/help', 'pages.help')->name('help'); // Help page
Volt::route('/track-order', 'pages.track-order')->name('track-order'); // Track order page
Volt::route('/404', 'pages.404')->name('404'); // 404 error page
Volt::route('/503', 'pages.503')->name('500'); // 500 error page

// Shop and product routes
Volt::route('/shop', 'pages.catalogue')->name('shop.index'); // Shop homepage
Volt::route('/shop/{slug}', 'pages.category')->name('shop.category'); // Products in category
Volt::route('/product/{slug}', 'pages.product')->name('product.show'); // Product details

// Blog routes
Volt::route('/blogs', 'pages.blogs')->name('blog.index'); // Blog index
Volt::route('/blog/{slug}', 'pages.blog')->name('blog.show'); // Blog post

// Authenticated routes
Route::middleware(['auth', 'verified'])->group(function () {
    Volt::route('/dashboard', 'pages.dashboard')->name('dashboard'); // User dashboard
    Volt::route('/wishlist', 'pages.wishlist')->name('wishlist'); // Wishlist
    Volt::route('/cart', 'pages.cart')->name('cart'); // Cart
    Volt::route('/checkout', 'pages.checkout')->name('checkout'); // Checkout

    // Settings
    Route::redirect('/settings', '/settings/profile');
    Volt::route('/settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('/settings/password', 'settings.password')->name('settings.password');
    Volt::route('/settings/appearance', 'settings.appearance')->name('settings.appearance');
});

// Artisan migrate (production + admin only)
Route::get('/artisan-migrate', function () {
    if (app()->environment('production') && auth()->check() && auth()->user()->hasRole('admin')) {
        Artisan::call('migrate', ['--force' => true]);
        return 'Migrations executed successfully.';
    }
    abort(403, 'Unauthorized or not in production environment.');
})->name('artisan-migrate');

// Include auth routes
require __DIR__ . '/auth.php';
