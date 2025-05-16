<!DOCTYPE html>
<html lang="en" class="font-playfair overflow-x-hidden">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap"
          rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
    <script src="https://flowbite.com/docs/flowbite.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <title>{{ $title }}</title>
</head>
<body class="h-dvh relative">
<nav class="bg-pearl-bush-200 flex flex-row items-center px-6 py-4 fixed w-full justify-between z-20">
    <a href="/" class="text-cognac-800 @if(request()->is("/")) text-5xl @else text-4xl @endif">Not Fake AirBNB</a>
    <div class="left-1/2 ml-35">
        @if(request()->is('/'))
            <div class="flex gap-6 rounded-2xl px-4 py-3 bg-pearl-bush-100 text-black shadow-lg">
                <div class="flex flex-col items-start">
                    <label for="city" class="mb-1 font-semibold text-lg">City</label>
                    <input type="text" name="city" placeholder="Rome" min="0" class="border border-gray-500 transition-colors focus:ring-2 focus:ring-cognac-800 focus:outline-none rounded-md px-2 py-1 w-24 2xl:w-40"/>
                </div>
                <div class="flex flex-col items-start">
                    <label for="min_price" class="mb-1 font-semibold text-lg">Min Price</label>
                    <input type="number" name="min_price" placeholder="0" min="0" class="border border-gray-500 transition-colors focus:ring-2 focus:ring-cognac-800 focus:outline-none rounded-md px-2 py-1 w-24 2xl:w-40"/>
                </div>
                <div class="flex flex-col items-start">
                    <label for="max_price" class="mb-1 font-semibold text-lg">Max Price</label>
                    <input type="number" name="max_price" placeholder="0" min="0" class="border border-gray-500 transition-colors focus:ring-2 focus:ring-cognac-800 focus:outline-none rounded-md px-2 py-1 w-24 2xl:w-40"/>
                </div>
                <div class="flex flex-col items-start">
                    <label for="rooms" class="mb-1 font-semibold text-lg">Rooms</label>
                    <input type="number" name="rooms" placeholder="0" min="0" class="border border-gray-500 transition-colors focus:ring-2 focus:ring-cognac-800 focus:outline-none rounded-md px-2 py-1 w-24 2xl:w-40"/></div>
                <div class="flex flex-col items-start">
                    <label for="persons" class="mb-1 font-semibold text-lg">Persons</label>
                    <input type="number" name="persons" placeholder="0" min="0" class="border border-gray-500 transition-colors focus:ring-2 focus:ring-cognac-800 focus:outline-none rounded-md px-2 py-1 w-24 2xl:w-40"/></div>
            </div>
        @endif
    </div>
    <div class="flex flex-row space-x-6">
        <a href="rent" class="py-2 px-4 rounded-2xl bg-cognac-800 text-pearl-bush-200 text-3xl">NFAirBNB your house</a>
        <div class="flex flex-row py-2 px-4 rounded-2xl bg-cognac-800 text-pearl-bush-200 space-x-3">
            <a href="register" class="text-3xl p">Register</a>
            {{--<img src="/images/bb.avif" width="37" class="rounded-4xl">
            <a href="" class="text-3xl"> Username</a>--}}
        </div>
    </div>
</nav>

<div class=" h-screen @if(request()->is("/")) pt-35  @else pt-24 @endif px-12">
    @if ($errors->any())
        <div class="flex flex-col px-4 py-2 bg-cognac-700 rounded-2xl ">
            <ul class="space-y-1 px-2 py-2">
                @foreach ($errors->all() as $error)
                    <li class="text-lg">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    {{ $slot }}
</div>
</body>
</html>
