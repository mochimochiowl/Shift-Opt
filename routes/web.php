<?php

use App\Http\Controllers\AttendanceRecordController;
use App\Http\Controllers\TopController;
use App\Http\Controllers\UserConditionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserSalaryController;
use App\Http\Controllers\SummaryController;
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
Route::get('/', [TopController::class, 'get'])->name('top');

// ログイン・ログアウトにかかわるルート
Route::middleware('auth')->group(function () {
    Route::get('logout', [UserController::class, 'logout'])->name('logout');
});
Route::get('login', [UserController::class, 'showLogin'])->name('login.form');
Route::post('login', [UserController::class, 'login'])->name('login.store');

// 打刻にかかわるルート
Route::prefix('stamps')->name('stamps.')->group(function () {
    Route::get('/', [AttendanceRecordController::class, 'showStamp'])->name('index');
    Route::post('start-work', [AttendanceRecordController::class, 'startWork'])->name('startWork');
    Route::post('finish-work', [AttendanceRecordController::class, 'finishWork'])->name('finishWork');
    Route::post('start-break', [AttendanceRecordController::class, 'startBreak'])->name('startBreak');
    Route::post('finish-break', [AttendanceRecordController::class, 'finishBreak'])->name('finishBreak');
    Route::get('result', [AttendanceRecordController::class, 'showStampResult'])->name('result');
});

// DB操作にかかわるルート
Route::middleware('auth')->group(function () {
    // users
    Route::get('users/search', [UserController::class, 'showSearchPage'])->name('users.search');

    //CRUD
    Route::get('users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('users', [UserController::class, 'store'])->name('users.store');

    Route::get('users/{user_id}', [UserController::class, 'show'])->name('users.show');
    Route::get('users/{user_id}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('users/{user_id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('users/{user_id}', [UserController::class, 'destroy'])->name('users.delete');

    Route::get('users/{user_id}/create/result', [UserController::class, 'showCreateResult'])->name('users.create.result');
    Route::get('users/{user_id}/edit/result', [UserController::class, 'showUpdateResult'])->name('users.update.result');
    Route::post('users/{user_id}/delete/confirm', [UserController::class, 'confirmDestroy'])->name('users.delete.confirm');
    Route::get('users/{user_id}/delete/result', [UserController::class, 'showDestroyResult'])->name('users.delete.result');

    // userSalaries
    Route::get('users/{user_id}/salaries/edit', [UserSalaryController::class, 'edit'])->name('users.salaries.edit');
    Route::put('users/{user_id}/salaries', [UserSalaryController::class, 'update'])->name('users.salaries.update');
    Route::get('users/{user_id}/salaries/result', [UserSalaryController::class, 'showUpdateResult'])->name('users.salaries.update.result');

    // userConditions
    Route::get('users/{user_id}/conditions/edit', [UserConditionController::class, 'edit'])->name('users.conditions.edit');
    Route::put('users/{user_id}/conditions', [UserConditionController::class, 'update'])->name('users.conditions.update');
    Route::get('users/{user_id}/conditions/result', [UserConditionController::class, 'showUpdateResult'])->name('users.conditions.update.result');

    // at_records
    Route::get('at_records/search', [AttendanceRecordController::class, 'showSearchPage'])->name('at_records.search');
    Route::get('at_records/export-csv', [AttendanceRecordController::class, 'exportCsv'])->name('at_records.export');

    //CRUD
    Route::get('at_records/create', [AttendanceRecordController::class, 'create'])->name('at_records.create');
    Route::post('at_records', [AttendanceRecordController::class, 'createRecordByAdmin'])->name('at_records.store');
    Route::get('at_records/{at_record_id}', [AttendanceRecordController::class, 'show'])->name('at_records.show');
    Route::get('at_records/{at_record_id}/edit', [AttendanceRecordController::class, 'edit'])->name('at_records.edit');
    Route::put('at_records/{at_record_id}', [AttendanceRecordController::class, 'update'])->name('at_records.update');
    Route::delete('at_records/{at_record_id}', [AttendanceRecordController::class, 'destroy'])->name('at_records.delete');

    Route::get('at_records/{at_record_id}/create/result', [AttendanceRecordController::class, 'showCreateResult'])->name('at_records.create.result');
    Route::get('at_records/{at_record_id}/edit/result', [AttendanceRecordController::class, 'showUpdateResult'])->name('at_records.update.result');
    Route::post('at_records/{at_record_id}/delete/confirm', [AttendanceRecordController::class, 'confirmDestroy'])->name('at_records.delete.confirm');
    Route::get('at_records/{at_record_id}/delete/result', [AttendanceRecordController::class, 'showDestroyResult'])->name('at_records.delete.result');

    // summary
    Route::get('summary/index', [SummaryController::class, 'index'])->name('summary.index');
    Route::post('summary/post', [SummaryController::class, 'post'])->name('summary.post');
    Route::get('summary/show', [SummaryController::class, 'showSummary'])->name('summary.show');
});
