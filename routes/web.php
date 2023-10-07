<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StampController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SearchController;

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
    Route::get('userInfo', [UserController::class, 'showLoggedInUserInfo'])->name('userInfo');
    Route::post('logout', [UserController::class, 'logout']);
});

Route::get('login', [UserController::class, 'showLogin'])->name('login');
Route::post('login', [UserController::class, 'login']);

Route::get('stamp', [StampController::class, 'index'])->name('stamp');
Route::post('stamp', [StampController::class, 'index'])->name('stamp');

Route::post('stamp/startWork', [StampController::class, 'startWork']);
Route::post('stamp/finishWork', [StampController::class, 'finishWork']);
Route::post('stamp/startBreak', [StampController::class, 'startBreak']);
Route::post('stamp/finishBreak', [StampController::class, 'finishBreak']);

Route::get('stamp/result', [StampController::class, 'showResult'])->name('stampResult');

Route::get('search', [SearchController::class, 'showSearchView']);
Route::post('search/result', [SearchController::class, 'showResult']);

Route::post('search/userInfo', [UserController::class, 'showUserInfo']);
