<!DOCTYPE html>
<html lang="en" class="bg-pearl-bush-50 font-playfair overflow-x-hidden">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap"
          rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet"/>
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
            <form method="get" action="{{ route('apartment.search') }}"
                  class="flex gap-6 rounded-2xl px-4 py-3 bg-pearl-bush-100 text-black shadow-lg">
                @csrf
                <div class="flex flex-col items-start">
                    <label for="city" class="mb-1 font-semibold text-lg">City</label>
                    <input type="text" name="city" placeholder="Rome" min="0"
                           class="border border-gray-500 transition-colors focus:ring-2 focus:ring-cognac-800 focus:outline-none rounded-md px-2 py-1 w-28"/>
                </div>
                <div class="flex flex-col items-start">
                    <label for="min_price" class="mb-1 font-semibold text-lg">Min Price</label>
                    <input type="number" name="min_price" placeholder="0" min="0"
                           class="border border-gray-500 transition-colors focus:ring-2 focus:ring-cognac-800 focus:outline-none rounded-md px-2 py-1 w-28"/>
                </div>
                <div class="flex flex-col items-start">
                    <label for="max_price" class="mb-1 font-semibold text-lg">Max Price</label>
                    <input type="number" name="max_price" placeholder="0" min="0"
                           class="border border-gray-500 transition-colors focus:ring-2 focus:ring-cognac-800 focus:outline-none rounded-md px-2 py-1 w-28"/>
                </div>
                <div class="flex flex-col items-start">
                    <label for="rooms" class="mb-1 font-semibold text-lg">Rooms</label>
                    <input type="number" name="rooms" placeholder="0" min="0"
                           class="border border-gray-500 transition-colors focus:ring-2 focus:ring-cognac-800 focus:outline-none rounded-md px-2 py-1 w-28"/>
                </div>
                <div class="flex flex-col items-start">
                    <label for="persons" class="mb-1 font-semibold text-lg">Persons</label>
                    <input type="number" name="persons" placeholder="0" min="0"
                           class="border border-gray-500 transition-colors focus:ring-2 focus:ring-cognac-800 focus:outline-none rounded-md px-2 py-1 w-28"/>
                </div>
                <div class="flex flex-col items-start">
                    <button type="submit" id="but"
                            class="border border-gray-600 mt-8 bg-cognac-800 text-white transition-colors hover:bg-cognac-900 rounded-md px-2 py-1 w-28">
                        Search
                    </button>
                </div>
            </form>
        @endif
    </div>
    <div class="flex flex-row h-17 space-x-6">
        @auth
        @if(auth()->user()->admin)
            <a href="{{route('adminpanel')}}"
               class="px-4 rounded-2xl bg-cognac-800 text-white text-3xl flex items-center">Admin panel</a>
        @endif
        @endauth
        <a href="{{route('apartment.create')}}"
           class="px-4 rounded-2xl bg-cognac-800 text-white text-3xl flex items-center">NFAirBNB
            your
            house</a>
        @guest
            <div class="flex flex-row py-2 px-4 rounded-2xl bg-cognac-800 text-pearl-bush-200 space-x-3">
                <a href="{{ route('registered') }}" class="text-3xl flex items-center">Register</a>
            </div>
        @endguest
        @auth
            <a href="{{ route('userprofile.user', $user = auth()->id())}}"
               class="text-3xl bg-cognac-800 px-4 py-2 rounded-2xl">
                <div class="flex flex-row space-x-2 h-full">
                    @if(auth()->user()->profile_img)
                    <img src="{{ '/storage/images/' . auth()->user()->profile_img }}" class="rounded-full w-14 h-14">
                    @endif
                        <p class="text-white flex items-center">{{auth()->user()->name}}</p>
                    </div>
                </a>
            @endauth
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
