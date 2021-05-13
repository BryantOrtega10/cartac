<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
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
Route::get('/', function() {
    return 'Cartac';
});
Route::get('/migrate', function() {
    $exitCode = Artisan::call('migrate');
    $exitCode2 = Artisan::call('db:seed');
    return '<h3>Migración completada '.$exitCode.' '.$exitCode2.'</h3>';
});