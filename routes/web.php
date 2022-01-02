<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\PostController;

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
    Log::debug('Log Activated');
    return view('login');
});




Route::get('/user-page', function () {
    return view('user-page');
});

Route::get('/home', function () {
    return view('home');
});


Route::get('/register', [PostController::class, 'index']);

// POST Data
Route::post('/register-data', [PostController::class, 'store']);
