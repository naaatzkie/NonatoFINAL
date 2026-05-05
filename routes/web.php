<?php

use App\Http\Controllers\FoundItemController;
use App\Http\Controllers\LostItemController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('found-items.index');
});

Route::get('/dashboard', function () {
    return redirect()->route('found-items.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Found items
    Route::resource('found-items', FoundItemController::class)->only(['index', 'create', 'store', 'show']);
    Route::patch('found-items/{foundItem}/claim', [FoundItemController::class, 'claim'])->name('found-items.claim');

    // Lost items
    Route::resource('lost-items', LostItemController::class)->only(['index', 'create', 'store', 'show']);

    // Notifications
    Route::get('notifications', [NotificationController::class, 'index'])->name('notifications.index');
});

require __DIR__.'/auth.php';
