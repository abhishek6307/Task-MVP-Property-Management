<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\FavoriteController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('properties', PropertyController::class);
});

Route::prefix('properties/{id}')->group(function () {
    Route::get('/', [PropertyController::class, 'show'])->name('properties.show');
    Route::post('/favorite', [FavoriteController::class, 'toggleFavorite'])->name('properties.favorite');
    Route::post('/inquiry', [PropertyController::class, 'submitInquiry'])->name('properties.inquiry');
    Route::post('/schedule', [PropertyController::class, 'scheduleViewing'])->name('properties.schedule');
    Route::post('/toggle-like', [PropertyController::class, 'toggleLike'])->name('properties.toggle-like');
    Route::post('/share', [PropertyController::class, 'share'])->name('properties.share');
});
Route::get('/favorites', [App\Http\Controllers\FavoriteController::class, 'index'])->name('favorites.index');

Route::get('/map', [PropertyController::class, 'map'])->name('properties.map');
require __DIR__.'/auth.php';
