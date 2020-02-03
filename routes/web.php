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

Route::get('/{any}', function () {
    return view('welcome');
})->where('any', '.*');

// use App\Transaction;
// use Carbon\Carbon;

// Route::get('/', function () {
//     return Transaction::whereDate('created_at', Carbon::now('Asia/Manila')->toDateString())->count();
// });