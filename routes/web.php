<?php

use App\Livewire\Dashboard;
use App\Livewire\Mitra\IndexMitra;
use Illuminate\Support\Facades\Route;
use App\Livewire\Pengguna\IndexPengguna;
use App\Http\Controllers\GoogleController;
use App\Livewire\Kendaraan\IndexKendaraan;

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::controller(GoogleController::class)->group(function () {
    Route::get('auth/google', 'redirectToGoogle')->name('auth.google');
    Route::get('auth/google/callback', 'handleGoogleCallback');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', Dashboard::class);

    Route::get('/mitra', IndexMitra::class);
    Route::get('/kendaraan', IndexKendaraan::class);
    Route::get('/pengguna', IndexPengguna::class);
});
