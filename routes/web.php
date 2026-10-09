<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SetupController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Setup Wizard Routes
|--------------------------------------------------------------------------
*/
Route::get('/setup', [SetupController::class, 'welcome'])->name('setup.welcome');
Route::get('/setup/database', [SetupController::class, 'database'])->name('setup.database');
Route::post('/setup/database', [SetupController::class, 'saveDatabase'])->name('setup.database.save');
Route::get('/setup/migrations', [SetupController::class, 'migrations'])->name('setup.migrations');
Route::post('/setup/migrations', [SetupController::class, 'runMigrations'])->name('setup.migrations.run');
Route::get('/setup/admin', [SetupController::class, 'admin'])->name('setup.admin');
Route::post('/setup/admin', [SetupController::class, 'saveAdmin'])->name('setup.admin.save');
Route::get('/setup/complete', [SetupController::class, 'complete'])->name('setup.complete');

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
Route::get('/property-insurance', [AdminController::class, 'showPropertyInsurance'])->name('property-insurance');
Route::get('/liability-insurance', [AdminController::class, 'showLiabilityInsurance'])->name('liability-insurance');
Route::get('/group-benefits', [AdminController::class, 'showGroupBenefits'])->name('group-benefits');
Route::get('/specialty-coverage', [AdminController::class, 'showSpecialtyCoverage'])->name('specialty-coverage');
Route::get('/coverage', [AdminController::class, 'showCoverage'])->name('coverage');
Route::get('/custom-quote', [AdminController::class, 'showCustomQuote'])->name('custom-quote');
Route::get('/compare', [AdminController::class, 'showCompare'])->name('compare');
Route::get('/story', [AdminController::class, 'showStory'])->name('story');
Route::get('/team', [AdminController::class, 'showTeam'])->name('team');
Route::get('/careers', [AdminController::class, 'showCareers'])->name('careers');
Route::get('/community', [AdminController::class, 'showCommunity'])->name('community');
Route::get('/articles', [AdminController::class, 'showArticles'])->name('articles');
Route::get('/faqs', [AdminController::class, 'showFaqs'])->name('faqs');
Route::get('/guides', [AdminController::class, 'showGuides'])->name('guides');
Route::get('/business-insurance', [AdminController::class, 'showBusinessInsurance'])->name('business-insurance');
Route::get('/claims', [AdminController::class, 'showClaims'])->name('claims');
Route::get('/payment', [AdminController::class, 'showPayment'])->name('payment');
Route::get('/contact', [AdminController::class, 'showContact'])->name('contact');

Route::post('/quotes', [AdminController::class, 'storePublicQuote'])->name('quotes.store');

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::match(['get', 'post'], '/check-email', [AuthController::class, 'checkEmail'])->name('check-email');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Customer / Policyholder Portal (Requires Authentication)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');
    Route::get('/dashboard/policies', [UserController::class, 'policies'])->name('user.policies');
    Route::get('/dashboard/quote', [UserController::class, 'quote'])->name('user.quote');
    Route::get('/dashboard/claims', [UserController::class, 'claims'])->name('user.claims');
    Route::get('/dashboard/documents', [UserController::class, 'documents'])->name('user.documents');
    Route::get('/dashboard/payments', [UserController::class, 'payments'])->name('user.payments');
    Route::get('/dashboard/support', [UserController::class, 'support'])->name('user.support');
    Route::get('/dashboard/settings', [UserController::class, 'settings'])->name('user.settings');

    Route::post('/dashboard/claims', [UserController::class, 'submitClaim'])->name('user.claims.store');
    Route::post('/dashboard/quotes', [UserController::class, 'requestQuote'])->name('user.quotes.store');
    Route::post('/dashboard/invoices/{id}/pay', [UserController::class, 'payInvoice'])->name('user.invoices.pay');
});

// Agent & Underwriter Admin Portal (Requires Authentication + Admin/Agent Role)
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::post('/admin/quotes', [AdminController::class, 'storeQuote'])->name('admin.quotes.store');
    Route::patch('/admin/quotes/{id}/status', [AdminController::class, 'updateQuoteStatus'])->name('admin.quotes.status');
    Route::delete('/admin/quotes/{id}', [AdminController::class, 'deleteQuote'])->name('admin.quotes.delete');
    Route::post('/admin/home-insurance', [AdminController::class, 'updateHomeInsurance'])->name('admin.home-insurance.update');
    Route::post('/admin/auto-insurance', [AdminController::class, 'updateAutoInsurance'])->name('admin.auto-insurance.update');
    Route::post('/admin/personal-coverage', [AdminController::class, 'updatePersonalCoverage'])->name('admin.personal-coverage.update');
    Route::post('/admin/property-insurance', [AdminController::class, 'updatePropertyInsurance'])->name('admin.property-insurance.update');
    Route::post('/admin/liability-insurance', [AdminController::class, 'updateLiabilityInsurance'])->name('admin.liability-insurance.update');
    Route::post('/admin/group-benefits', [AdminController::class, 'updateGroupBenefits'])->name('admin.group-benefits.update');
    Route::post('/admin/specialty-coverage', [AdminController::class, 'updateSpecialtyCoverage'])->name('admin.specialty-coverage.update');
    Route::post('/admin/coverage', [AdminController::class, 'updateCoverage'])->name('admin.coverage.update');
    Route::post('/admin/custom-quote', [AdminController::class, 'updateCustomQuote'])->name('admin.custom-quote.update');
    Route::post('/admin/compare', [AdminController::class, 'updateCompare'])->name('admin.compare.update');
    Route::post('/admin/story', [AdminController::class, 'updateStory'])->name('admin.story.update');
    Route::post('/admin/team', [AdminController::class, 'updateTeam'])->name('admin.team.update');
    Route::post('/admin/careers', [AdminController::class, 'updateCareers'])->name('admin.careers.update');
    Route::post('/admin/community', [AdminController::class, 'updateCommunity'])->name('admin.community.update');
    Route::post('/admin/articles', [AdminController::class, 'updateArticles'])->name('admin.articles.update');
    Route::post('/admin/faqs', [AdminController::class, 'updateFaqs'])->name('admin.faqs.update');
    Route::post('/admin/guides', [AdminController::class, 'updateGuides'])->name('admin.guides.update');
    Route::post('/admin/business-insurance', [AdminController::class, 'updateBusinessInsurance'])->name('admin.business-insurance.update');
    Route::post('/admin/claims', [AdminController::class, 'updateClaims'])->name('admin.claims.update');
    Route::post('/admin/payment', [AdminController::class, 'updatePayment'])->name('admin.payment.update');
    Route::post('/admin/contact', [AdminController::class, 'updateContact'])->name('admin.contact.update');

    // API Integrations (Claims API & US Payments)
    Route::post('/admin/api/claims', [AdminController::class, 'saveClaimsApiConfig'])->name('admin.api.claims.update');
    Route::post('/admin/api/claims/test', [AdminController::class, 'testClaimsApiConnection'])->name('admin.api.claims.test');
    Route::post('/admin/api/payments', [AdminController::class, 'savePaymentApiConfig'])->name('admin.api.payments.update');

    // Invoices Management System
    Route::post('/admin/invoices', [AdminController::class, 'storeInvoice'])->name('admin.invoices.store');
    Route::post('/admin/invoices/{id}/pay', [AdminController::class, 'processInvoicePayment'])->name('admin.invoices.pay');
    Route::patch('/admin/invoices/{id}/status', [AdminController::class, 'updateInvoiceStatus'])->name('admin.invoices.status');

    // User & Account Management System
    Route::patch('/admin/users/{id}/role', [AdminController::class, 'updateUserRole'])->name('admin.users.role');
    Route::delete('/admin/users/{id}', [AdminController::class, 'deleteUser'])->name('admin.users.delete');
});
