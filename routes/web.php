<?php

use App\Http\Controllers\CrudController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::post('saveform', [CrudController::class, 'saveform'])->name('savefrom');
Route::get('getrecords', [CrudController::class, 'getrecords'])->name('getrecords');
Route::get('delete/{record}', [CrudController::class, 'delete'])->name('delete');
Route::get('getrec/{record}', [CrudController::class, 'getrec'])->name('getrec');
