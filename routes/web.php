<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\MahasiswaController;
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
    return view('welcome');
});

Route::get('/articles/cetak_pdf', [ArticleController::class, 'cetak_pdf']);

Route::get('/mahasiswa/nilai/{nim}', [MahasiswaController::class, 'showKhs'])->name('mahasiswa.showKhs');
Route::get('/mahasiswa/nilai/{nim}/cetak_khs', [MahasiswaController::class, 'cetak_khs'])->name('mahasiswa.cetakKhs');

Route::resource('articles', ArticleController::class);

Route::resource('mahasiswa', MahasiswaController::class);

