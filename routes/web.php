<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;

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

    $reply = Http::withToken(config('services.openai.secret'))
        ->post('https://api.openai.com/v1/chat/completions', [
            "model" => "gpt-3.5-turbo",
            "messages" => [
                [
                    "role" => "system",
                    "content" => "You are a poetic assistant, skilled in explaining complex programming concepts with creative flair."
                ],
                [
                    "role" => "user",
                    "content" => "Compose a poem that explains the concept of laravel framework."
                ]
            ]
    ])->json('choices.0.message.content');

    return view('welcome', ['reply' => $reply]);
});
