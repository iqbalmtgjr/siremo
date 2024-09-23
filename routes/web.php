<?php

use App\Livewire\Dashboard;
use App\Livewire\Kendaraan\IndexKendaraan;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', Dashboard::class);

Route::get('/kendaraan', IndexKendaraan::class);
