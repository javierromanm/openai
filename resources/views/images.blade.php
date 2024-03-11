<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Open AI Image Generation</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100">       

    <nav class="bg-white border-gray-200 dark:bg-gray-900">
    <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
        <a href="{{ route('home') }}" class="flex items-center space-x-3 rtl:space-x-reverse">
            <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">Interact with OpenAI</span>
        </a>
        <button data-collapse-toggle="navbar-default" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600" aria-controls="navbar-default" aria-expanded="false">
            <span class="sr-only">Open main menu</span>
            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15"/>
            </svg>
        </button>
        <div class="hidden w-full md:block md:w-auto" id="navbar-default">
        <ul class="font-medium flex flex-col p-4 md:p-0 mt-4 border border-gray-100 rounded-lg bg-gray-50 md:flex-row md:space-x-8 rtl:space-x-reverse md:mt-0 md:border-0 md:bg-white dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700">
            <li>
            <a href="{{ route('home') }}" class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">Home</a>
            </li>
            <li>
            <a href="{{ route('text') }}" class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">Text</a>
            </li>
            <li>
            <a href="{{ route('speech') }}" class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">Speech</a>
            </li>
            <li>
            <a href="{{ route('images') }}" class="block py-2 px-3 text-white bg-blue-700 rounded md:bg-transparent md:text-blue-700 md:p-0 dark:text-white md:dark:text-blue-500" aria-current="page">Images</a>
            </li>    
            <li>
            <a href="{{ route('spam') }}" class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">Spam</a>
            </li>       
            <li>
            <a href="{{ route('assistant') }}" class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">Assistant</a>
            </li>       
        </ul>
        </div>
    </div>
    </nav>

    <div class="flex gap-6 mx-auto max-w-3xl bg-white py-6 px-10 rounded-xl mt-5">
        <div>
            <h1 class="font-bold mb-4">Generate an image</h1>
            <form action="/images" method="POST" class="w-full lg:max-w-md lg:max-auto">
                @csrf                
                <textarea 
                    name="description" 
                    cols="30"
                    rows="5" 
                    placeholder="Description of the image" 
                    class="border border-gray-600 text-xs p-2 rounded"
                ></textarea>
                <p class="mt-2">
                    <button type="submit" class="border border-black px-2 rounded bg-gray-200 hover:bg-blue-500 hover:text-white">Create image</button>   
                </p>
            </form>
            <form action="/reset" method="POST" class="w-full lg:max-w-md lg:max-auto">
                @csrf  
                <p class="mt-2">
                    <button type="submit" class="border border-black px-2 rounded bg-gray-200 hover:bg-blue-500 hover:text-white">Reset previous messages</button>   
                </p>
            </form>
        </div>
        <div>
            @if(count($messages))
                <div class="space-y-6">
                    @foreach(array_chunk($messages,2) as $chunk)
                        <div>
                            <p class="font-bold text-sm mb-1">{{ $chunk[0]['content'] }}</p>
                            <img src="{{ $chunk[1]['content'] }}" alt="" style="max-width: 250px">                            
                        </div>
                    @endforeach                    
                </div>                
            @endif
        </div>
    </div>     
</body>
</html>
