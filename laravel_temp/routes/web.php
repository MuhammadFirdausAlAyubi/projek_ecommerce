<?php

use App\Http\Controllers\UserControllers;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home.dashboard');
});
