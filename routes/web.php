<?php

use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\ProviderController;
use App\Http\Controllers\UtilityController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('utilities.index');
});

Route::get('/utilities', [UtilityController::class, 'index'])->name('utilities.index');
Route::resource('providers', ProviderController::class);
Route::resource('incomes', IncomeController::class);
Route::resource('expenses', ExpenseController::class);