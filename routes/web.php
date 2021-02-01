<?php

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

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/pesan/{id}', 'PesanController@index');
Route::post('/pesan/{id}', 'PesanController@pesan');

Route::get('keranjang', 'PesanController@keranjang');
Route::post('konfirmasi', 'PesanController@konfirmasi');
Route::delete('keranjang/{id}', 'PesanController@hapus');

Route::get('riwayat', 'PesanController@riwayat');
Route::get('riwayatdetail/{id}', 'PesanController@riwayat_detail');
