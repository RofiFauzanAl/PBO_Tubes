<?php

use Illuminate\Support\Facades\Route;
use App\Models\Buku;
use Illuminate\Http\Request;

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

Auth::routes();

Route::resource('users', \App\Http\Controllers\UserController::class)
    ->middleware('auth');

Route::resource('books', \App\Http\Controllers\BookController::class)
    ->middleware('auth');

// Untuk Meminjam
Route::get('/borrows', '\App\Http\Controllers\LendController@index')->name('getIndexBorrows')->middleware('auth');
Route::put('/borrows/{id}/{user}', '\App\Http\Controllers\LendController@update')->name('setUpdateBorrows')->middleware('auth');

// Route Untuk Melihat data Transaksi
Route::get('/transaksi', '\App\Http\Controllers\TransaksiController@index')->name('getTransaksi')->middleware('auth');
// Route::get('/borrows', $lend.index());

// Route::post('/borrows/:id', \App\Http\Controllers\BookController::class);

Route::get('/home', function() {
    return view('home');
})->name('home')->middleware('auth');