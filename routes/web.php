<?php

use App\OpenAI\Chat;
use Illuminate\Support\Facades\Route;
use OpenAI\Laravel\Facades\OpenAI;

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
    return view('welcome');
})->name('home');

Route::get('/text', function () {

    $chat = new Chat();

    $chat
        ->assistant('You are a poetic assistant, skilled in explaining complex programming concepts with creative flair.')
        ->say('Compose a poem that explains the concept of laravel framework.');

    $response = $chat->say('Can you make it sarcastic?');

    return view('text', ['reply' => $response]);
})->name('text');

Route::get('/speech', function () {

    return view('speech');
})->name('speech');

Route::post('/speech', function () {
    $attributes = request()->validate(['topic' => ['required', 'string', 'min:2', 'max:50']]);
    $chat = new Chat();
    $mp3 = $chat->say(
        message: 'Can you create a poem about ' . $attributes['topic'],
        speech: true
    );
    $file = '/audio/' . md5($mp3) . '.mp3';
    file_put_contents(public_path($file), $mp3);
    return redirect('/speech')->with([
        'file' => $file,
        'flash' => 'Poem created'
    ]);
});

Route::get('/images', function () {
    return view('images', [
        'messages' => session('messages', [])
    ]);
})->name('images');

Route::post('/images', function () {
    $attributes = request()->validate([
        'description' => ['required', 'string', 'min:3']
    ]);

    $chat = new Chat(session('messages', []));

    $url = $chat->visualize($attributes['description']);

    session(['messages' => $chat->messages()]);
    
    return redirect('/images');
});

Route::post('/reset', function () {
    session()->forget('messages');  
    return redirect('/images');
});
