<?php

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Route;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\RecoverPassword;
use App\Livewire\Dashboard;

Route::middleware('guest')->group(function(){
    Route::get('/', Login::class)->name('login');
    Route::get('/recover-password', RecoverPassword::class)->name('recover-password');
});

Route::middleware(['auth', 'verified'])->group(function(){
    Route::get('/', Dashboard::class)->name('dashboard');
});



