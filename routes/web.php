<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SitioController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/sitios/mapa', [SitioController::class, 'mapa'])->name('sitios.mapa');

Route::resource('sitios', SitioController::class);
