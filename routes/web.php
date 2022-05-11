<?php

use App\Http\Controllers\CasController;
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

Route::get('/export', function () {
    return view('export');
});

Route::post('/export', [CasController::class, 'exportCsv'])->name('export');

Route::get('/cas', function () {
    return view('cas');
});

Route::post('/cas', [CasController::class, 'getCas'])->name('cas');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
