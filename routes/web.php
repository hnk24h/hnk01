<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UploadS3Controller;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/upload', [UploadS3Controller::class, 'index']);
Route::post('/upload', [UploadS3Controller::class, 'create'])->name('upload');
Route::get('/create', [UploadS3Controller::class, 'store'])->name('store');
Route::get('/show', [UploadS3Controller::class, 'show'])->name('show');