<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;

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

Route::get('/', [BookController::class, 'index']);

// Books CRUD routes.
Route::resource('books', \App\Http\Controllers\BookController::class);

// Importer routes
Route::get('import', [\App\Http\Controllers\ImportController::class, 'importForm']);
Route::post('import', [\App\Http\Controllers\ImportController::class, 'import'])->name('import');
