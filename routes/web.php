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

Route::get('/home-insurance', [AdminController::class, 'showHomeInsurance'])->name('home-insurance');
Route::get('/auto-insurance', [AdminController::class, 'showAutoInsurance'])->name('auto-insurance');
Route::get('/personal-coverage', [AdminController::class, 'showPersonalCoverage'])->name('personal-coverage');
Route::get('/specialty-coverage', [AdminController::class, 'showSpecialtyCoverage'])->name('specialty-coverage');
Route::get('/business-insurance', [AdminController::class, 'showBusinessInsurance'])->name('business-insurance');

Route::post('/quotes', [AdminController::class, 'storePublicQuote'])->name('quotes.store');

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Agent & Underwriter Admin Portal (Requires Authentication)
Route::middleware(['auth'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::post('/admin/quotes', [AdminController::class, 'storeQuote'])->name('admin.quotes.store');
    Route::patch('/admin/quotes/{id}/status', [AdminController::class, 'updateQuoteStatus'])->name('admin.quotes.status');
    Route::delete('/admin/quotes/{id}', [AdminController::class, 'deleteQuote'])->name('admin.quotes.delete');
    Route::post('/admin/home-insurance', [AdminController::class, 'updateHomeInsurance'])->name('admin.home-insurance.update');
    Route::post('/admin/auto-insurance', [AdminController::class, 'updateAutoInsurance'])->name('admin.auto-insurance.update');
    Route::post('/admin/personal-coverage', [AdminController::class, 'updatePersonalCoverage'])->name('admin.personal-coverage.update');
    Route::post('/admin/specialty-coverage', [AdminController::class, 'updateSpecialtyCoverage'])->name('admin.specialty-coverage.update');
    Route::post('/admin/business-insurance', [AdminController::class, 'updateBusinessInsurance'])->name('admin.business-insurance.update');

    // API Integrations (Claims API & US Payments)
    Route::post('/admin/api/claims', [AdminController::class, 'saveClaimsApiConfig'])->name('admin.api.claims.update');
    Route::post('/admin/api/claims/test', [AdminController::class, 'testClaimsApiConnection'])->name('admin.api.claims.test');
    Route::post('/admin/api/payments', [AdminController::class, 'savePaymentApiConfig'])->name('admin.api.payments.update');

    // Invoices Management System
    Route::post('/admin/invoices', [AdminController::class, 'storeInvoice'])->name('admin.invoices.store');
    Route::post('/admin/invoices/{id}/pay', [AdminController::class, 'processInvoicePayment'])->name('admin.invoices.pay');
    Route::patch('/admin/invoices/{id}/status', [AdminController::class, 'updateInvoiceStatus'])->name('admin.invoices.status');
});
