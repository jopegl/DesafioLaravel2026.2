<?php

use App\Http\Controllers\Api\CepController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/api/cep/{zipCode}', [CepController::class, 'search'])->name('cep.search');
