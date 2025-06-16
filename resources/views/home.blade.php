
<x-layout>
    <x-slot:title>
        Home
    </x-slot:>
    @if(request()->is("/"))
        <h1 class="font-semibold text-center text-8xl mb-20">Most rented locations</h1>
        <div class="element w-full grid grid-cols-3 place-items-center gap-12 mb-10">
            @foreach($apartmentsMR as $cities)
                <div class="flex flex-col w-full justify-between space-y-5">
                    <h1 class="font-semibold text-center text-5xl">{{ $cities[0]->city }}</h1>
                    @foreach($cities as $MRapartment)
                        <div class="bg-white pb-3 w-full group/MRapartments rounded-3xl">
                            <a href="{{ route('apartment.detail', ['apartment' => $MRapartment->id]) }}">
                                <label for="default-carousel"
                                       class="text-3xl bg-white w-full block rounded-t-3xl pl-6 font-bold">{{ $MRapartment->street }}</label>
                            </a>
                            <div id="default-carousel" class="relative w-full" data-carousel="static">
                                <!-- Carousel wrapper -->
                                <div class="relative w-full h-96 overflow-hidden z-15 hover:z-14">
                                    <!-- Items -->
                                    @foreach($MRapartment->images as $image)
                                        <div class="hidden duration-700 ease-in-out w-full z-14 hover:z-14"
                                             data-carousel-item>
                                            <img src="{{ url('storage/' . $image->path) }}"
                                                 class="absolute block w-full h-96 object-cover"
                                                 alt="Carousel image">
                                        </div>
                                    @endforeach
                                </div>
                                <!-- Slider indicators -->
                                <div
                                    class="absolute z-15 flex -translate-x-1/2 bottom-5 left-1/2 space-x-3 rtl:space-x-reverse">
                                    @foreach($MRapartment->images as $image)
                                        <button type="button"
                                                class="w-2 h-2 rounded-full"
                                                aria-current="{{$loop->index === 0 ? 'true' : 'false'}}"
                                                aria-label="Slide {{ $loop->index + 1 }}"
                                                data-carousel-slide-to="{{$loop->index}}">
                                        </button>
                                    @endforeach
                                </div>
                                <!-- Slider controls -->
                                <button type="button"
                                        class="absolute top-45 start-0 z-15 flex items-center justify-center h-1/10 px-4 cursor-pointer opacity-0 group-hover/MRapartments:opacity-100  transition-opacity duration-400 focus:outline-none"
                                        data-carousel-prev>
                            <span
                                class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-white hover:scale-105 hover:opacity-100 opacity-70 transition-all group-focus/MRapartments:outline-none">
                                <svg class="w-2.5 h-2.5 text-black" aria-hidden="true"
                                     xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 8 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                          stroke-width="2"
                                          d="M5 1 1 5l4 4"/>
                                </svg>
                                <span class="sr-only">Previous</span>
                            </span>
                                </button>
                                <button type="button"
                                        class="absolute  top-45 end-0 z-15 flex items-center justify-center h-1/10 px-4 cursor-pointer opacity-0 group-hover/MRapartments:opacity-100 transition-opacity duration-400  focus:outline-none"
                                        data-carousel-next>
                            <span
                                class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-white hover:scale-105 hover:opacity-100 opacity-70 transition-all group-focus/MRapartments:outline-none">
                                <svg class="w-2.5 h-2.5 text-black" aria-hidden="true"
                                     xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 4 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                          stroke-width="2"
                                          d="m1 9 4-4-4-4"/>
                                </svg>
                                <span class="sr-only">Next</span>
                            </span>
                                </button>
                            </div>
                            <a class="mb-5" href="{{ route('apartment.detail', ['apartment' => $MRapartment->id]) }}">
                                <div class="text-wrap text-xl w-full line-clamp-1 h-8 mt-2 font-normal px-4">
                                    {{ $MRapartment->description }}
                                </div>
                                <p class="text-xl font-bold pl-4 underline">{{ $MRapartment->price }} CHF <span
                                        class="font-extralight">night</span></p>
                            </a>
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>
        <hr class="mb-10">
    @elseif(request()->filled('city'))
        @if($apartments->isEmpty())
            <div>
                <h1 class="text-center font-semibold text-6xl mb-16 mt-6 text-gray-800">
                    We don't have any listings in {{request()->city}} yet, but, you could be the <a href="{{route('apartment.create')}}" class="text-blue-500 hover:text-blue-600">first lessor</a> here!
                </h1>
            </div>
        @else
            <h1 class="font-bold text-center text-6xl mb-16 mt-6 text-gray-800">
                Upcoming Events in {{ $apartments[0]->city }}
            </h1>
            <div class="grid grid-cols-2 gap-8 px-6 pb-10">
                @foreach($events as $event)
                    <div
                        class="flex bg-white rounded-2xl shadow-md hover:shadow-xl hover:scale-101 transition-all duration-300 overflow-hidden">
                        <div class="w-45 h-auto">
                            <img src="@if(isset($event['image']))
                             {{ $event['image'] }}
                            @else
                            {{ $event['thumbnail'] }}
                            @endif"


                                     alt="Event image"
                                 class="w-full h-full object-cover">
                        </div>
                        <div class="w-2/3 p-4 flex flex-col justify-between space-y-2">
                            <h2 class="text-2xl font-semibold text-gray-900 line-clamp-1">{{ $event['title'] }}</h2>
                            <p class="text-gray-600 text-xl line-clamp-1">
                                <a href="{{ $event['event_location_map']['link'] }}"
                                   class="text-blue-600 hover:underline">
                                    {{ $event['address'][0] }}
                                </a>
                            </p>
                            <p class="text-gray-700 text-xl">
                                <span class="font-medium">Start Date: </span>{{ $event['date']['start_date'] }}</p>
                            <p class="text-gray-700 text-xl">
                                <span class="font-xl">More info:</span>
                                <a href="{{ $event['link'] }}"
                                   class="text-blue-600 hover:underline">{{ $event['ticket_info'][0]['source'] }}</a>
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
            <hr class="pb-5">
        @endif
    @endif

    <div class="grid grid-cols-5 gap-18 m-5 pb-20">
        @foreach($apartments as $apartment)
            <div
                class="h-118 space-y-2 rounded-3xl shadow-md hover:shadow-xl hover:scale-101 transition-all duration-300 pb-3 group/allApartments">
                <div id="test-carousel">
                    <div id="default-carousel" class="relative w-full" data-carousel="static">
                        <!-- Carousel wrapper -->
                        <div class="relative h-80 overflow-hidden rounded-t-3xl z-15 hover:z-14">
                            <!-- Items -->
                            @foreach($apartment->images as $image)
                                <div class="hidden duration-700 ease-in-out z-14 hover:z-14" data-carousel-item>
                                    <img src="{{ url('storage/' . $image->path) }}"
                                         class="absolute block w-full h-full object-cover"
                                         alt="Carousel image">
                                </div>
                            @endforeach
                        </div>
                        <!-- Slider indicators -->
                        <div
                            class="absolute z-15 flex -translate-x-1/2 bottom-5 left-1/2 space-x-3 rtl:space-x-reverse">
                            @foreach($apartment->images as $image)
                                <button type="button"
                                        class="w-2 h-2 rounded-full"
                                        aria-current="{{$loop->index === 0 ? 'true' : 'false'}}"
                                        aria-label="Slide {{ $loop->index + 1 }}"
                                        data-carousel-slide-to="{{$loop->index}}">
                                </button>
                            @endforeach
                        </div>
                        <!-- Slider controls -->
                        <button type="button"
                                class="absolute top-37 start-0 z-15 flex items-center justify-center h-1/10 px-4 cursor-pointer opacity-0 group-hover/allApartments:opacity-100  transition-opacity duration-400 focus:outline-none"
                                data-carousel-prev>
                            <span
                                class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-white hover:scale-105 hover:opacity-100 opacity-70 transition-all group-focus/allApartments:outline-none">
                                <svg class="w-2.5 h-2.5 text-black" aria-hidden="true"
                                     xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 8 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                          stroke-width="2"
                                          d="M5 1 1 5l4 4"/>
                                </svg>
                                <span class="sr-only">Previous</span>
                            </span>
                        </button>
                        <button type="button"
                                class="absolute  top-37 end-0 z-15 flex items-center justify-center h-1/10 px-4 cursor-pointer opacity-0 group-hover/allApartments:opacity-100 transition-opacity duration-400  focus:outline-none"
                                data-carousel-next>
                            <span
                                class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-white hover:scale-105 hover:opacity-100 opacity-70 transition-all group-focus/allApartments:outline-none">
                                <svg class="w-2.5 h-2.5 text-black" aria-hidden="true"
                                     xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 4 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                          stroke-width="2"
                                          d="m1 9 4-4-4-4"/>
                                </svg>
                                <span class="sr-only">Next</span>
                            </span>
                        </button>
                    </div>
                </div>
                <a href="{{ route('apartment.detail', ['apartment' => $apartment->id]) }}">
                    <p class="text-2xl line-clamp-1 font-bold pl-4">{{ $apartment->country }}
                        , {{ $apartment->city }}</p>
                    <div class="text-wrap text-lg w-full line-clamp-2 h-15 font-normal px-4 break-words">
                        {{ $apartment->description }}
                    </div>
                    <p class="text-lg font-bold pl-4 underline">{{ $apartment->price }} CHF <span
                            class="font-extralight">night</span></p>
                </a>
            </div>
        @endforeach
    </div>
</x-layout>
