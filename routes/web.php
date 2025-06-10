<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SafetyObservationController;

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

Route::get('/safety-observation/form', [SafetyObservationController::class, 'create'])->name('safety-observation.form');
Route::post('/safety-observation/store', [SafetyObservationController::class, 'store'])->name('safety-observation.store');
