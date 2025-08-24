<?php

use Illuminate\Support\Facades\Route;

Route::view('/login', 'auth.login')->name('login');
Route::view('/cars',  'cars.index')->name('cars.index');
Route::redirect('/', '/login');
