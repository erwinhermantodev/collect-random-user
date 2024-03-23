<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DailyRecordController;

Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');

Route::get('/daily-records', [DailyRecordController::class, 'index'])->name('daily_records.index');

Route::get('/', function () {
    return view('welcome');
});
