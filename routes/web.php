<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RepairController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\SummaryController;

Route::get('/', function () {
    return redirect()->route('repairs.index');
});

Route::resource('clients', ClientController::class);
Route::resource('repairs', RepairController::class);
Route::post('/repairs/{repair}/expenses', [ExpenseController::class, 'store'])
    ->name('expenses.store');

// Gastos Generales
Route::get('/expenses', [ExpenseController::class, 'index'])->name('expenses.index');
Route::get('/expenses/create', [ExpenseController::class, 'create'])->name('expenses.create');
Route::post('/expenses', [ExpenseController::class, 'storeGeneral'])->name('expenses.storeGeneral');
Route::delete('/expenses/{expense}', [ExpenseController::class, 'destroy'])->name('expenses.destroy');

Route::get('/summary', [SummaryController::class, 'index'])
    ->name('summary.index');
Route::patch('/repairs/{repair}/status', [RepairController::class, 'updateStatus'])
    ->name('repairs.updateStatus');
Route::get('/repairs/{repair}/charge', [RepairController::class, 'charge'])
    ->name('repairs.charge');

Route::patch('/repairs/{repair}/charge', [RepairController::class, 'storeCharge'])
    ->name('repairs.storeCharge');
