<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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


// OBS!
// To begin with, make sure to run the following in terminal: composer require maatwebsite/excel --ignore-platform-reqs

// After that, in: config/app.php
// include this in providers array: Maatwebsite\Excel\ExcelServiceProvider::class,
// and this in aliases array: 'Excel' => Maatwebsite\Excel\Facades\Excel::class

// then run this from phpstorm terminal: php artisan vendor:publish --provider="Maatwebsite\Excel\ExcelServiceProvider"
// Should now see the message: "Publishing complete."

// Now we need to create fake data for tests, go into tinker mode: php artisan tinker
// Now create fake content: User::factory()->count(50)->create();
// Then exit the tinker mode: exit

Route::get('/', function () {
    return view('welcome');
});

Route::get('file-import-export', [UserController::class, 'fileImportExport']);
Route::post('file-import', [UserController::class, 'fileImport'])->name('file-import');
Route::get('file-export', [UserController::class, 'fileExport'])->name('file-export');
