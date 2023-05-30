<?php

use App\Http\Controllers\API\ApartmentCategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ApartmentController;
use App\Http\Controllers\API\MessageController;
use App\Http\Controllers\API\ServiceController;
use App\Http\Controllers\API\ViewsController;
use App\Http\Middleware\ApartmentsMiddleware;
use App\Http\Middleware\SearchMiddleware;



/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/apartments', [ApartmentController::class, 'index'])->middleware(ApartmentsMiddleware::class);
Route::get('/showcase', [ApartmentController::class, 'showCase']);
Route::get('/apartments/{apartment:slug}', [ApartmentController::class, 'show']);
Route::get('/services', [ServiceController::class, 'index']);
Route::get('/categories', [ApartmentCategoryController::class, 'index']);
Route::post('/messages', [MessageController::class, 'store']);
Route::post('/views', [ViewsController::class, 'addView']);
Route::get('/views/{apartment:id}', [ViewsController::class, 'currentViews'])->middleware(['auth', 'verified']);
Route::get('/search', [ApartmentController::class, 'search'])->middleware(SearchMiddleware::class)->name('search');
