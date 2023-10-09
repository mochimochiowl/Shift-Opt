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

// 検索にかかわるルート
Route::get('users/search', [SearchController::class, 'showSearchView'])->name('users.search');
Route::post('users/search', [SearchController::class, 'showResult'])->name('users.search.result');

// ユーザー情報操作にかかわるルート
Route::get('users/{user_id}', [UserController::class, 'showUserInfo'])->name('users.show');
Route::get('users/{user_id}/edit', [UserController::class, 'showUserEdit'])->name('users.edit');
Route::put('users/{user_id}', [UserController::class, 'updateUser'])->name('users.update');
Route::delete('users/{user_id}', [UserController::class, 'deleteUser'])->name('users.delete');

// 確認画面や結果画面などのルート
Route::get('users/{user_id}/edit/result', [UserController::class, 'showUserUpdateResult'])->name('users.update.result');
Route::post('users/{user_id}/delete/confirm', [UserController::class, 'showUserDeleteConfirmation'])->name('users.delete.confirm');
Route::get('users/{user_id}/delete/result', [UserController::class, 'showUserDeleteResult'])->name('users.delete.result');
