<?php

use App\Http\Controllers\ImportFileController;
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

Route::get('/', [ImportFileController::class, 'index']);
Route::resources([
    'import' => ImportFileController::class,
]);
Route::get('batch/{id}', [ImportFileController::class, 'batch']);

