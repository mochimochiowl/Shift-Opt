<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StampController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('top');
});
Route::post('/', function () {
    return view('top');
});
Route::get('register', [UserController::class, 'showRegister']);
Route::post('register', [UserController::class, 'createUser']);
Route::middleware('auth')->group(function () {
    Route::get('userInfo', [UserController::class, 'showUserInfo'])->name('userInfo');
    Route::post('logout', [UserController::class, 'logout']);
});

Route::get('login', [UserController::class, 'showLogin'])->name('login');
Route::post('login', [UserController::class, 'login']);

Route::get('stamp', [StampController::class, 'index']);
Route::post('stamp', [StampController::class, 'post']);
Route::post('stamp/debugShukkin', [StampController::class, 'debugShukkin']);
Route::post('stamp/debugTaikin', [StampController::class, 'debugTaikin']);
