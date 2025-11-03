<?php
use App\Http\Controllers\ProductController; 
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Продукти
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

// Кошик
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{id}', [CartController::class, 'addToCart'])->name('cart.add');
Route::get('/cart/remove/{id}', [CartController::class, 'removeFromCart'])->name('cart.remove');
Route::post('/cart/clear', [CartController::class, 'clearCart'])->name('cart.clear');

require __DIR__.'/auth.php';

// Адмін роути - простий варіант
Route::middleware(['web', 'auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', function () {
        if (!auth()->user()->is_admin) {
            abort(403, 'Доступ заборонено. Потрібні права адміністратора.');
        }
        return view('admin.dashboard');
    })->name('dashboard');
    
    Route::resource('products', \App\Http\Controllers\Admin\ProductController::class);
});
