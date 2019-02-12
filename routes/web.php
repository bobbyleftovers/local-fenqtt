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

Route::get('/', 'LocalLiteBrite@index');
Route::post('/create-submission', 'LocalLiteBrite@store');
Route::get('/upload-submission/{id}', 'LocalLiteBrite@upload');
