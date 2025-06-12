<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SitioController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/sitios/mapa', [SitioController::class, 'mapa'])->name('sitios.mapa');

Route::get('/sitios/galeria', [SitioController::class, 'galeria'])->name('sitios.galeria');

Route::get('/sitios/maparapido', [SitioController::class, 'maparapido'])->name('sitios.maparapido');

Route::get('/sitios/nuevorapido', [SitioController::class, 'nuevorapido'])->name('sitios.nuevorapido');

Route::resource('sitios', SitioController::class);
