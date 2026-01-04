<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RepairController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\SummaryController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('repairs', RepairController::class);
Route::post('/repairs/{repair}/expenses', [ExpenseController::class, 'store'])
    ->name('expenses.store');
Route::get('/summary', [SummaryController::class, 'index'])
    ->name('summary.index');
Route::patch('/repairs/{repair}/status', [RepairController::class, 'updateStatus'])
    ->name('repairs.updateStatus');
Route::get('/repairs/{repair}/charge', [RepairController::class, 'charge'])
    ->name('repairs.charge');

Route::patch('/repairs/{repair}/charge', [RepairController::class, 'storeCharge'])
    ->name('repairs.storeCharge');
