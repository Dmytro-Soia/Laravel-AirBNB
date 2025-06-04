<x-layout>
    <x-slot:title>
        Rooms
    </x-slot:title>
    <div class="flex justify-between">
        <h1 class="text-4xl ml-15 self-center">{{ $apartment->title }}</h1>
        <div class="flex flex-row justify-around px-6 w-2/7 items-center h-20 mb-2">
            @auth
            @if(auth()->user()->id === $apartment->owner_id || auth()->user()->admin)
            <form action="/edit/{{$apartment->id}}" method="get">
                @csrf
                <button
                    class="border rounded-2xl text-center text-xl px-9 py-3 bg-cognac-800 text-white hover:bg-cognac-900 min-w-33"
                    type="submit">Edit post
                </button>
            </form>
            <form action="/delete/{{$apartment->id}}" method="post">
                @csrf
                <button
                    class="border rounded-2xl text-center text-xl px-9 py-3 bg-cognac-800 text-white hover:bg-cognac-900 min-w-33"
                    type="submit">Delete post
                </button>
            </form>
                @endif
            @endauth
        </div>
    </div>
    <div class="grid grid-cols-[70%_30%] grid-rows-2h-full">
        <div id="test-carousel" class="h-4/5 mx-10">
            <div id="default-carousel" class="relative" data-carousel="static">
                <!-- Carousel wrapper -->
                <div class="relative h-200 z-10 overflow-hidden rounded-3xl">
                    <!-- Item 1 -->
                    @foreach($apartment->images as $image)
                        <div class="hidden duration-700 ease-in-out z-14 hover:z-14" data-carousel-item>
                            <img src="{{ url('storage/' . $image->path) }}"
                                 class="absolute block w-full h-full object-cover"
                                 alt="Carousel image">
                        </div>
                    @endforeach
                </div>
                <!-- Slider indicators -->
                <div class="absolute z-30 flex -translate-x-1/2 bottom-5 left-1/2 space-x-3 rtl:space-x-reverse">
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
                        class="absolute top-5/11 start-0 z-15 flex items-center justify-center h-1/10 px-4 cursor-pointer  group-hover:opacity-100  transition-opacity duration-400 focus:outline-none"
                        data-carousel-prev>
                            <span
                                class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white hover:scale-105 hover:opacity-100 opacity-70 transition-all group-focus:outline-none">
                                <svg class="w-4 h-4 text-black" aria-hidden="true"
                                     xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 8 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                          stroke-width="2"
                                          d="M5 1 1 5l4 4"/>
                                </svg>
                                <span class="sr-only">Previous</span>
                            </span>
                </button>
                <button type="button"
                        class="absolute top-5/11 end-0 z-15 flex items-center justify-center h-1/10 px-4 cursor-pointer  group-hover:opacity-100 transition-opacity duration-400  focus:outline-none"
                        data-carousel-next>
                            <span
                                class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white hover:scale-105 hover:opacity-100 opacity-70 transition-all group-focus:outline-none">
                                <svg class="w-4 h-4 text-black" aria-hidden="true"
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
        <div class="row-span-2 h-full ml-10">
            <form method="get" action="{{ route('booking.checkout', ['apartment' => $apartment->id]) }}"
                  class="flex shadow-2xl flex-col h-full justify-between items-center bg-pearl-bush-200 border border-border-grey w-full rounded-4xl px-8 py-6 space-y-8">
                @csrf
                <div class="flex flex-row bg-cognac-800 rounded-2xl gap-4 text-center">
                    @foreach($weather['forecastDays'] as $day)
                        <div class="flex flex-col  p-4">
                            <p class="text-lg font-semibold text-white">{{jdmonthname($day['displayDate']['month'], 3)}} - {{ $day['displayDate']['day'] }}</p>
                            <img src="{{ $day['daytimeForecast']['weatherCondition']['iconBaseUri'] }}.svg" alt="weather icon" class="mx-auto h-10 my-2">

                            <p class="text-md text-white">Max: {{ $day['maxTemperature']['degrees'] }}°C</p>
                            <p class="text-md text-white">Min: {{ $day['minTemperature']['degrees'] }}°C</p>
                        </div>
                    @endforeach
                </div>
                <div class="flex flex-row items-start w-2/3 m-0 p-0 bg-cognac-800 justify-center h-100 rounded-2xl mt-5">
                    <div class="flex flex-col w-4/5 items-center mt-5"><input name="dates" id="dates" required type="date" class="w-full rounded-xl text-2xl text-center">
                    </div>
                </div>
                <div class="w-full bg-cognac-800 text-white rounded-2xl p-5 text-left">
                    <p class="text-2xl underline underline-offset-4">CHF {{ $apartment->price }} per night</p>
                    <p class="text-lg mt-2">Developer fee: <strong>100 CHF</strong></p>
                </div>
                <div class="flex flex-col w-full">
                    <label for="guest_number" class="text-lg font-semibold text-cognac-800 mb-2">Number of Guests</label>
                    <input type="number"
                           name="guest_number"
                           required
                           placeholder="Number of guests"
                           min="1" max="{{ $apartment->max_people }}"
                           class="w-full rounded-2xl py-2 px-4 border border-border-grey focus:ring-2 focus:ring-cognac-800 focus:outline-none transition-all text-xl">
                </div>
                <button
                    type="submit"
                    class="w-full text-2xl py-4 rounded-3xl bg-cognac-800 hover:bg-cognac-900 text-white transition-colors">
                    Checkout Billing Information
                </button>
            </form>
        </div>
        <div class="w-full">
            <textarea rows="10" disabled
                      class="pl-5 resize-none mt-10 w-full text-lg rounded-2xl ring-2 ring-cognac-800 pr-5">{{$apartment->description}}</textarea>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            flatpickr("#dates", {
                mode: "range",
                inline: true,
                minDate: "today",
                dateFormat: "Y-m-d",
                disable: [
                    @foreach($bookings as $booking)
                    {
                        from: "{{ $booking->reserved_at }}",
                        to: "{{ $booking->expired_at }}"
                    },
                    @endforeach
                ],
                onChange: function (selectedDates, dateStr, instance) {
                    if (selectedDates.length === 2 && selectedDates[0].getTime() === selectedDates[1].getTime()) {
                        instance.selectedDates = [selectedDates[0], selectedDates[0]];
                        instance.input.value = instance.formatDate(selectedDates[0], "Y-m-d") + " to " + instance.formatDate(selectedDates[0], "Y-m-d");
                    }
                    }
            });
        });
    </script>
</x-layout>
