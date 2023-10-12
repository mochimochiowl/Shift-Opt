<?php

use App\Http\Controllers\AttendanceRecordController;
use App\Http\Controllers\StampController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

// トップページのルート
Route::view('/', 'top')->name('top');

// ユーザー登録・ログイン・ログアウトにかかわるルート
Route::get('users/create', [UserController::class, 'create'])->name('users.create');
Route::post('users', [UserController::class, 'store'])->name('users.store');

Route::middleware('auth')->group(function () {
    Route::get('logout', [UserController::class, 'logout'])->name('logout');
});
Route::get('login', [UserController::class, 'showLogin'])->name('login.form');
Route::post('login', [UserController::class, 'login'])->name('login.store');

// 勤怠にかかわるルート
Route::prefix('stamps')->name('stamps.')->group(function () {
    Route::get('/', [StampController::class, 'index'])->name('index');
    Route::post('start-work', [StampController::class, 'startWork'])->name('startWork');
    Route::post('finish-work', [StampController::class, 'finishWork'])->name('finishWork');
    Route::post('start-break', [StampController::class, 'startBreak'])->name('startBreak');
    Route::post('finish-break', [StampController::class, 'finishBreak'])->name('finishBreak');
    Route::get('result', [StampController::class, 'showResult'])->name('result');
});

// DB閲覧、編集にはログインが必要
Route::middleware('auth')->group(function () {
    // users
    // 検索にかかわるルート
    Route::get('users/search', [SearchController::class, 'showUsersSearchView'])->name('users.search');
    Route::post('users/search', [SearchController::class, 'showUsersResult'])->name('users.search.result');

    // 情報操作にかかわるルート
    Route::get('users/{user_id}', [UserController::class, 'show'])->name('users.show');
    Route::get('users/{user_id}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('users/{user_id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('users/{user_id}', [UserController::class, 'destroy'])->name('users.delete');

    // 確認画面や結果画面などのルート
    Route::get('users/{user_id}/edit/result', [UserController::class, 'showUpdateResult'])->name('users.update.result');
    Route::post('users/{user_id}/delete/confirm', [UserController::class, 'confirmDestroy'])->name('users.delete.confirm');
    Route::get('users/{user_id}/delete/result', [UserController::class, 'showDestroyResult'])->name('users.delete.result');

    // at_record
    // 検索にかかわるルート
    Route::get('at_records/search', [SearchController::class, 'showAtRecordsSearchView'])->name('at_records.search');
    Route::post('at_records/search', [SearchController::class, 'showAtRecordsResult'])->name('at_records.search.result');

    // 情報操作にかかわるルート
    Route::get('at_records/create', [AttendanceRecordController::class, 'create'])->name('at_records.create');
    Route::post('at_records', [AttendanceRecordController::class, 'store'])->name('at_records.store');
    Route::get('at_records/{at_record_id}', [AttendanceRecordController::class, 'show'])->name('at_records.show');
    Route::get('at_records/{at_record_id}/edit', [AttendanceRecordController::class, 'edit'])->name('at_records.edit');
    Route::put('at_records/{at_record_id}', [AttendanceRecordController::class, 'update'])->name('at_records.update');
    Route::delete('at_records/{at_record_id}', [AttendanceRecordController::class, 'destroy'])->name('at_records.delete');

    // 確認画面や結果画面などのルート
    Route::get('at_records/{at_record_id}/edit/result', [AttendanceRecordController::class, 'showUpdateResult'])->name('at_records.update.result');
    Route::post('at_records/{at_record_id}/delete/confirm', [AttendanceRecordController::class, 'confirmDestroy'])->name('at_records.delete.confirm');
    Route::get('at_records/{at_record_id}/delete/result', [AttendanceRecordController::class, 'showDestroyResult'])->name('at_records.delete.result');
});
