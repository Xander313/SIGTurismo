<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SitioController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('sitios', SitioController::class);
