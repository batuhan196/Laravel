<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\QrCodeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Student routes
    Route::get('/my-loans', [LoanController::class, 'myLoans'])->name('loans.my');
    Route::get('/catalog', [BookController::class, 'catalog'])->name('books.catalog');

    // QR Code routes (accessible by all authenticated users)
    Route::get('/qr/scan', [QrCodeController::class, 'scan'])->name('qr.scan');
    Route::get('/qr/{id}', [QrCodeController::class, 'show'])->name('qr.show');

    // Admin routes
    Route::middleware([\App\Http\Middleware\AdminMiddleware::class])->group(function () {
        // Books
        Route::resource('books', BookController::class);
        Route::get('/books-trashed', [BookController::class, 'trashed'])->name('books.trashed');
        Route::post('/books/{id}/restore', [BookController::class, 'restore'])->name('books.restore');
        Route::delete('/books/{id}/force-delete', [BookController::class, 'forceDelete'])->name('books.forceDelete');

        // Categories
        Route::resource('categories', CategoryController::class)->except(['show']);

        // Loans
        Route::resource('loans', LoanController::class)->except(['show', 'edit', 'update']);
        Route::post('/loans/{id}/return', [LoanController::class, 'returnBook'])->name('loans.return');

        // Users
        Route::resource('users', UserController::class)->except(['show']);

        // QR Code print all
        Route::get('/qr/print/all', [QrCodeController::class, 'generateAll'])->name('qr.printAll');
    });
});

require __DIR__.'/auth.php';
