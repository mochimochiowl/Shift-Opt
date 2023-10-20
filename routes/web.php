<?php

use App\Http\Controllers\AttendanceRecordController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\TopController;
use App\Http\Controllers\UserConditionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserSalaryController;
use App\Http\Services\StampService;
use App\Http\Services\SummaryService;
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

//デバッグ用
Route::view('debug', 'debug.index')->name('debug');
Route::view('debug/loginForm', 'debug.css.loginForm')->name('debug.loginForm');
Route::view('debug/table', 'debug.css.table')->name('debug.table');

// トップページのルート
Route::get('/', [TopController::class, 'get'])->name('top');
Route::post('/', [TopController::class, 'post'])->name('top.post');

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
    Route::get('/', [StampService::class, 'index'])->name('index');
    Route::post('start-work', [StampService::class, 'startWork'])->name('startWork');
    Route::post('finish-work', [StampService::class, 'finishWork'])->name('finishWork');
    Route::post('start-break', [StampService::class, 'startBreak'])->name('startBreak');
    Route::post('finish-break', [StampService::class, 'finishBreak'])->name('finishBreak');
    Route::get('result', [StampService::class, 'showResult'])->name('result');
});

// DB閲覧、編集にはログインが必要
Route::middleware('auth')->group(function () {
    // users
    // 検索にかかわるルート
    Route::get('users/search', [SearchController::class, 'showUsers'])->name('users.search');

    // 情報操作にかかわるルート
    Route::get('users/{user_id}', [UserController::class, 'show'])->name('users.show');
    Route::get('users/{user_id}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('users/{user_id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('users/{user_id}', [UserController::class, 'destroy'])->name('users.delete');

    Route::get('users/{user_id}/salaries/edit', [UserSalaryController::class, 'edit'])->name('users.salaries.edit');
    Route::put('users/{user_id}/salaries', [UserSalaryController::class, 'update'])->name('users.salaries.update');
    Route::get('users/{user_id}/conditions/edit', [UserConditionController::class, 'edit'])->name('users.conditions.edit');
    Route::put('users/{user_id}/conditions', [UserConditionController::class, 'update'])->name('users.conditions.update');

    // 確認画面や結果画面などのルート
    Route::get('users/{user_id}/edit/result', [UserController::class, 'showUpdateResult'])->name('users.update.result');
    Route::post('users/{user_id}/delete/confirm', [UserController::class, 'confirmDestroy'])->name('users.delete.confirm');
    Route::get('users/{user_id}/delete/result', [UserController::class, 'showDestroyResult'])->name('users.delete.result');

    Route::get('users/{user_id}/salaries/result', [UserSalaryController::class, 'showUpdateResult'])->name('users.salaries.update.result');
    Route::get('users/{user_id}/conditions/result', [UserConditionController::class, 'showUpdateResult'])->name('users.conditions.update.result');

    // at_record
    // 検索にかかわるルート
    Route::get('at_records/search', [SearchController::class, 'showAtRecords'])->name('at_records.search');

    // CSV出力
    Route::get('at_records/export-csv', [SearchController::class, 'exportAtRecordCsv'])->name('at_records.export');

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

    // 集計画面にかかわるルート
    Route::get('summary/index', [SummaryService::class, 'index'])->name('summary.index');
    Route::post('summary/post', [SummaryService::class, 'post'])->name('summary.post');
    Route::get('summary/show', [SummaryService::class, 'showSummary'])->name('summary.show');
});
