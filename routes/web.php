<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Auth::routes();

Route::get('/', function () {
    return view('pages.home');
});

Route::get('/about', function () {
    return view('pages.about');
})->name('about');


Route::view('/privacy-policy', 'pages.privacy')->name('privacy');
Route::view('/terms', 'pages.terms')->name('terms');

Route::middleware('auth')->group(function () {
    Route::view('/dashboard', 'dashboard.index')->name('dashboard');

    Route::middleware('role:Admin')->group(function () {
        Route::view('/dashboard/users', 'dashboard.users')->name('dashboard.users');
        Route::view('/dashboard/logs', 'dashboard.logs')->name('dashboard.logs');
    });

    Route::middleware('role:Admin,Employee')->group(function () {
        Route::view('/dashboard/rooms', 'dashboard.rooms')->name('dashboard.rooms');
        Route::view('/dashboard/amenities', 'dashboard.amenities')->name('dashboard.amenities');
        Route::view('/dashboard/reservations', 'dashboard.reservations')->name('dashboard.reservations');
        Route::view('/dashboard/approvals', 'dashboard.approvals')->name('dashboard.approvals');
    });

    Route::middleware('role:Customer')->group(function () {
        Route::view('/dashboard/my-reservations', 'dashboard.my-reservations')->name('dashboard.my-reservations');
        Route::view('/dashboard/reserve', 'dashboard.reserve')->name('dashboard.reserve');
    });
});
