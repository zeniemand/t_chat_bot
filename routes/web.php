<?php

use Illuminate\Support\Facades\Route;

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


Route::get('/', function (\App\Helpers\Telegram $telegram) {
    $telegram->sendMessage(env('CHAT_ID'), 'hellochen!!!');
    $telegram->sendMessage(env('CHAT_ID'), 'cats_logo')->sendDocument(env('CHAT_ID'), 'cats_logo_1.png');
    $telegram->sendDocument(env('CHAT_ID'), 'cats_logo_1.png');
    $telegram->sendMessage(env('CHAT_ID'), 'cats_logo');
    return view('welcome');
});
