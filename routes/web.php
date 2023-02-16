<?php

use App\Http\Controllers\ApartmentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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
        Route::get('promotions/{apartment:slug}', [PaymentController::class, 'index'])->name('promo');
        Route::get('purchase/{apartment:slug}/{promotion:id}', [PaymentController::class, 'show'])->name('promo.purchase');
        Route::post('/promotions/process-payment/{apartment:slug}/{promotion:id}/', [PaymentController::class, 'handlePayment'])->name('promo.process-payment');
        Route::resource('apartments', ApartmentController::class)->parameters([
            'apartments' => 'apartment:slug',
        ]);
        Route::get('messages', [ApartmentController::class, 'messages'])->prefix('apartements')->name('apartments.messages');
    });

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



require __DIR__ . '/auth.php';
