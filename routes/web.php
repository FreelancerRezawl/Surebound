<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public Website
Route::get('/', function () {
    return view('home');
})->name('home');

Route::post('/quotes', [AdminController::class, 'storePublicQuote'])->name('quotes.store');

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Agent & Underwriter Admin Portal
Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
Route::post('/admin/quotes', [AdminController::class, 'storeQuote'])->name('admin.quotes.store');
Route::patch('/admin/quotes/{id}/status', [AdminController::class, 'updateQuoteStatus'])->name('admin.quotes.status');
Route::delete('/admin/quotes/{id}', [AdminController::class, 'deleteQuote'])->name('admin.quotes.delete');
