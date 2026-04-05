<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', [App\Http\Controllers\FrontendController::class, 'index'])->name('frontend.index');
Route::get('/blogfrontend/{slug}', [App\Http\Controllers\FrontendController::class, 'show'])->name('frontend.blog.show');

Auth::routes();

 


Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
    Route::resource('blog', App\Http\Controllers\BlogController::class)->names('blog');
    
});