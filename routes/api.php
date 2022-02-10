<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\V1\MainController as Main;
use App\Http\Controllers\Api\V1\UserController as User;
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

Route::middleware([])->prefix('auth')->group(function () {
    Route::post('login', [AuthController::class, 'login'])->name('mainLogin');
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);
    Route::post('register', [AuthController::class, 'register'])->name('register');
});



Route::middleware(['auth:api'])->prefix('user')->group(function () {
    Route::post('get-wish', [User::class, 'getWish'])->name('getWish');
    Route::post('add-wish', [User::class, 'addWish'])->name('addWish');
    Route::post('delete-wish', [User::class, 'deleteWish'])->name('deleteWish');
    Route::post('sub-email', [User::class, 'subEmail'])->name('subEmail');
    Route::post('unsub-email', [User::class, 'unsubEmail'])->name('unsubEmail');
});



Route::post('send-email', [Main::class, 'sendEmail'])->name('sendEmail');
Route::post('index', [Main::class, 'index'])->name('main');
Route::post('filter', [Main::class, 'filter'])->name('filter');

Route::post('brand', [Main::class, 'getBrand'])->name('getBrand');
Route::post('stores', [Main::class, 'getStores'])->name('getStores');