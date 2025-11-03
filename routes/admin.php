<?php

use App\Http\Controllers\Admin\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('admin.dashboard');
})->name('dashboard');

Route::resource('products', ProductController::class);
