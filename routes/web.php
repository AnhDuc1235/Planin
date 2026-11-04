<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes (Session-based)
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('app');
});
