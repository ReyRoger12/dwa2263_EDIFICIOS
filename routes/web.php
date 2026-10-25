<?php

use App\Http\Controllers\AulaController;
use App\Http\Controllers\EdificioWebController;
use App\Http\Controllers\MesaController;
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

Route::get('/', [AulaController::class, 'index'])->name('inicio');
Route::resource('aulas', AulaController::class)->except('show');
Route::name('panel.')->group(function () {
    Route::resource('edificios', EdificioWebController::class)->except('show');
});

Route::resource('mesas', MesaController::class);
