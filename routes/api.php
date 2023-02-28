<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\EventController;
use App\Http\Controllers\API\ProductsController;
use App\Http\Controllers\API\FrontController;

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

// Route Controllers for Login and Signin/logout
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
});

// Route Controllers for Events
Route::get('events', [EventController::class, 'index']);
Route::post('events', [EventController::class, 'store']);
Route::get('events/{id}/show', [EventController::class, 'show']);
Route::put('events/{id}/update', [EventController::class, 'update']);
Route::delete('events/{id}/delete', [EventController::class, 'destroy']);

// Route Controllers for Products
Route::get('products', [ProductsController::class, 'index']);
Route::post('products', [ProductsController::class, 'store']);
Route::get('products/{id}/show', [ProductsController::class, 'show']);
Route::put('products/{id}/update', [ProductsController::class, 'update']);
Route::delete('products/{id}/delete', [ProductsController::class, 'destroy']);

//
Route::get('getUpevent', [FrontController::class, 'upevent']);


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
