<?php

use App\OpenAI\Chat;
use Illuminate\Support\Facades\Route;

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

    $chat = new Chat();

    $chat
        ->assistant('You are a poetic assistant, skilled in explaining complex programming concepts with creative flair.')
        ->say('Compose a poem that explains the concept of laravel framework.');

    $response = $chat->say('Can you make it sarcastic?');

    return view('welcome', ['reply' => $response]);
});
