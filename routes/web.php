<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StampController;

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
Route::get('stamp', [StampController::class, 'index']);
Route::post('stamp', [StampController::class, 'post']);
