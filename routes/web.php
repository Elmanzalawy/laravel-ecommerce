<?php

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    auth()->user();
    auth()->id();

    return Carbon::now()->month(1)->daysInMonth();
    return view('welcome');
});
