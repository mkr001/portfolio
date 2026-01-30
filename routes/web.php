<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PortfolioController;

Route::get('/', [PortfolioController::class, 'index'])->name('home');
Route::post('/contact', [PortfolioController::class, 'sendMessage'])->name('contact.post');
Route::post('/request-callback', [PortfolioController::class, 'requestCallback'])->name('callback.post');


Route::get('/contact', function () {
    return redirect('/#contact');
})->name('contact.get');

Route::get('/request-callback', function () {
    return redirect('/#contact');
})->name('callback.get');

// Admin Routes
use App\Http\Controllers\AdminController;

// Admin Auth Routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminController::class, 'login'])->name('login');
    Route::post('/login', [AdminController::class, 'doLogin'])->name('login.post');
    Route::post('/logout', [AdminController::class, 'logout'])->name('logout');

    // Protected Admin Routes
    Route::middleware('admin.auth')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('dashboard');
        Route::get('/contacts', [AdminController::class, 'contacts'])->name('contacts');
        Route::get('/callbacks', [AdminController::class, 'callbacks'])->name('callbacks');
        Route::get('/projects', [AdminController::class, 'projects'])->name('projects');
        Route::post('/projects', [AdminController::class, 'storeProject'])->name('projects.store');
        Route::put('/projects/{project}', [AdminController::class, 'updateProject'])->name('projects.update');
        Route::delete('/projects/{project}', [AdminController::class, 'deleteProject'])->name('projects.delete');
        Route::post('/contacts/{contact}/read', [AdminController::class, 'markContactAsRead'])->name('contacts.read');
        Route::post('/callbacks/{callback}/read', [AdminController::class, 'markCallbackAsRead'])->name('callbacks.read');
    });
});




