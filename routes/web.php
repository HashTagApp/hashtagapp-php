<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\PostController;
use App\Http\Controllers\login;

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





Route::get('/user-page', function () {
    return view('user-page');
});




Route::get('/register', [PostController::class, 'index']);

// POST Data
Route::post('/register-data', [PostController::class, 'store']);


Route::get('/', [login::class, 'index']);
Log::debug('Log Activated');

// POST Data


Route::post('/main/checklogin', [login::class, 'checklogin']);
Route::post('/main/successlogin', [login::class, 'successlogin']);
Route::post('/main/logout', [login::class, 'logout']);


Route::get('/welcome', [login::class, 'successlogin']);

Route::get('/logout', [login::class, 'logout']);



