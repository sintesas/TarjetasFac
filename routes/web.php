<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\TarjetaController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('tarjetas/imprimirCard/{id}', [TarjetaController::class, 'index']);
Route::get('tarjetas/download/{id}', [TarjetaController::class, 'Download']);
