<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('admin.dashboard.main');
});

Route::get('/form', function () {
    return view('admin.form.main');
})->name('form');

