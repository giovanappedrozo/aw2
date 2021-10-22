<?php

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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/agenda', [App\Http\Controllers\AgendamentoController::class, 'index'])->name('agenda');
Route::get('/agendar', [App\Http\Controllers\AgendamentoController::class, 'create'])->name('agendar');
Route::post('/agendar/store', [App\Http\Controllers\AgendamentoController::class, 'store'])->name('agendar/store');
Route::get('/agendamento/{id}', [App\Http\Controllers\AgendamentoController::class, 'show']);
Route::post('/update', [App\Http\Controllers\AgendamentoController::class, 'update'])->name('update');