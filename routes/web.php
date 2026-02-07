<?php

use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\ProviderController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('providers.index');
});

Route::resource('providers', ProviderController::class);
Route::resource('incomes', IncomeController::class);
Route::resource('expenses', ExpenseController::class);