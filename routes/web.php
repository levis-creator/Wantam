<?php

use App\Livewire\Pages\Catalogue;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

// Route::get('/', function () {
//     return view('pages.welcome');
// })->name('home');

Route::view('/', 'pages.home')->name('home');
Route::view('dashboard', 'pages.dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');
Volt::route('/catalogue', 'pages.catalogue')->name('catalogue');
Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});
Route::get('/artisan-migrate', function () {
    if (app()->environment('production')) {
        Artisan::call('migrate', ['--force' => true]);
        return 'Migrations executed.';
    }
    abort(403);
});
require __DIR__ . '/auth.php';
