<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use TCG\Voyager\Facades\Voyager;

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('/guarda_historial', [App\Http\Controllers\HomeController::class, 'guarda_historial'])->name('guarda_historial');
Route::post('/carga_historial', [App\Http\Controllers\HomeController::class, 'carga_historial'])->name('carga_historial');

Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
