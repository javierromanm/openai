<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Open AI</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="h-full grid place-items-center p-6">   
    @if(session('file'))
        <div>
            <audio controls>
                <source src="{{ asset(session('file')) }}" type="audio/mpeg">
                Your browser does not support the audio element.
            </audio>
            <a href="{{ asset(session('file')) }}" download class="block p-2 w-full text-center rounded bg-gray-200 hover:bg-blue-500 hover:text-white mt-3">Download audio</a>
        </div>
    @else
        <form action="/speech" method="POST" class="w-full lg:max-w-md lg:max-auto">
            @csrf
            <div class="flex gap-2">
                <input name="topic" type="text" placeholder="What topic would you like?" class="border p-2 rounded flex-1">
                <button type="submit" class="p-2 rounded bg-gray-200 hover:bg-blue-500 hover:text-white">Create audio poem</button>
            </div>        
        </form>
    @endif
</body>
</html>
