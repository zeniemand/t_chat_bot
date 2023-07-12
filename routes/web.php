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
    $telegram->sendMessageWithButtons(env('CHAT_ID'), 'cats_logo')->sendDocument(env('CHAT_ID'), 'cats_logo_1.png');
    $telegram->sendDocument(env('CHAT_ID'), 'cats_logo_1.png');
    $telegram->sendMessage(env('CHAT_ID'), 'cats_logo');


    $buttonsEdit = [
        'inline_keyboard' => [
            [
                [
                    'text' => 'button1_1',
                    'callback_data' => '1'
                ],
                [
                    'text' => 'button2_2',
                    'callback_data' => '2'
                ]
            ]
        ]
    ];

    $telegram->editMessageWithButtons(env('CHAT_ID'), 'cats_logo', $buttonsEdit)->sendDocument(env('CHAT_ID'), 'cats_logo_1.png');



    return view('welcome');


});
