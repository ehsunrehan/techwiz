<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/markets', function () {
    return view('markets.index');
})->name('markets');

Route::get('/markets/{market}', function (string $market) {
    return view('markets.show', ['market' => $market]);
})->name('markets.show');



Route::get('/farmers', function () {
    return view('farmers.index');
})->name('farmers');

Route::get('/farmers/{farmer}', function (string $farmer) {
    return view('farmers.show', ['farmer' => $farmer]);
})->name('farmers.show');

Route::get('/events', function () {
    return view('events.index');
})->name('events');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::get('/privacy', function () {
    return view('privacy');
})->name('privacy');

Route::get('/terms', function () {
    return view('terms');
})->name('terms');

Route::get('/search', function () {
    // Query string 'q' se products/markets/farmers filter karein.
    return view('search-results');
})->name('search');

/*
|--------------------------------------------------------------------------
| Authentication (Login / Sign Up / Forgot / Reset)
|--------------------------------------------------------------------------
| Agar Jetstream/Breeze use kar rahe ho to yeh routes wo khud generate
| kar deta hai (php artisan breeze:install ya jetstream:install ke baad) —
| tab yeh block hata dena. Manually bana rahe ho to yahan se controllers
| wire kar dena.
*/

Route::middleware('guest')->group(function () {
    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');

    Route::get('/register', function () {
        return view('auth.register');
    })->name('register');

    Route::get('/forgot-password', function () {
        return view('auth.forgot-password');
    })->name('password.request');

    Route::get('/reset-password/{token}', function (string $token) {
        return view('auth.reset-password', ['token' => $token]);
    })->name('password.reset');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', function () {
        auth()->logout();
        return redirect()->route('home');
    })->name('logout');

    /*
    |----------------------------------------------------------------
    | Customer / Farmer / Admin areas
    |----------------------------------------------------------------
    | In sab ke views abhi nahi banaye — jab tumhara group in par kaam
    | shuru kare to yahan ${role}.dashboard, cart, orders wagera add
    | karte jaana, isi pattern se.
    */
});
