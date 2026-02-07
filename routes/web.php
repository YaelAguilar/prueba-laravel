<?php

use App\Http\Controllers\ProviderController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('providers.index');
});

Route::resource('providers', ProviderController::class);
