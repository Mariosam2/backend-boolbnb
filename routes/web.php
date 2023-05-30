<?php

use App\Http\Controllers\ApartmentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebhookController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/





Route::middleware(['auth', 'verified'])
    ->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');
        Route::get('products/{apartment:slug}', [PaymentController::class, 'index'])->name('products');
        Route::get('products/purchase/{apartment:slug}/{product:prod_id}', [PaymentController::class, 'show'])->name('products.purchase');
        Route::post('products/process-payment/{apartment:slug}/{product:prod_id}', [PaymentController::class, 'handlePayment'])->name('products.process-payment');
        Route::resource('apartments', ApartmentController::class)->parameters([
            'apartments' => 'apartment:slug',
        ]);
        Route::get('messages', [ApartmentController::class, 'messages'])->name('apartments.messages');
        Route::put('message/{id}/{all}', [ApartmentController::class, 'updateMessage'])->name('apartments.updateMessage');
        Route::get('splash-page', [ApartmentController::class, 'splashPage'])->name('splash-page');
    });


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::name('post-payment.')->prefix('post-payment')->group(function () {
    Route::post('/payment-intent', [WebhookController::class, 'paymentSucceded']);
    Route::post('/payment-invoice', [WebhookController::class, 'invoicePaid']);
});


require __DIR__ . '/auth.php';
