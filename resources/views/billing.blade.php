<x-layout>
    <x-slot:title>
        Billing
    </x-slot:title>
        <div class="w-3/4 h-full m-auto place-content-center">
            <form action="{{ $checkout->id }}/payed"
                  method="post"
                  class="grid xl:grid-cols-2 md:grid-cols-1 md:mt-10 md:gap-10 xl:gap-0 px-6 py-4 mb-24">
                @csrf
                <div class="bg-pearl-bush-200 rounded-tl-2xl p-8 w-full">
                    <h1 class="text-4xl font-bold mb-6 text-center">
                        Checkout billing information</h1>
                    <div class="flex flex-col gap-2">
                        <label for="title" class="ml-3 text-lg ">Title</label>
                        <input type="text" name="title" id="title"
                               placeholder="Name apartment"
                               class="border-gray-500 transition-all focus:outline-none focus:ring-2 focus:ring-cognac-800 border-1 rounded p-3"
                               value="{{ $checkout->title }}"
                               readonly
                               required>
                        <label for="description" class="ml-3 text-lg ">Description</label>
                        <textarea name="description" placeholder="Description"
                                  class="border-1 rounded p-3 border-gray-500 transition-all focus:outline-none focus:ring-2 focus:ring-cognac-800 resize-none"
                                  rows="4"
                                  readonly
                                  required>{{ $checkout->description }}</textarea>
                        <label for="rooms" class="ml-3 text-lg ">Rooms</label>
                        <input type="number" name="rooms" id="rooms" min="1" placeholder="Rooms"
                               class="border-1 rounded p-3 border-gray-500 transition-all focus:outline-none focus:ring-2 focus:ring-cognac-800"
                               value="{{ $checkout->rooms }}"
                               readonly
                               required>
                        <label for="max_people" class="ml-3 text-lg ">Max. people</label>
                        <input type="number" name="max_people" id="peoples"
                               min="1" placeholder="Max people"
                               class="border-1 rounded p-3 border-gray-500 transition-all focus:outline-none focus:ring-2 focus:ring-cognac-800"
                               value="{{ $checkout->max_people }}"
                               readonly
                               required>
                        <label for="price" class="ml-3 text-lg ">Price per night</label>
                        <input type="number" name="price" id="price"
                               placeholder="Price"
                               class="border-1 rounded p-3 border-gray-500 transition-all focus:outline-none focus:ring-2 focus:ring-cognac-800"
                               value="{{ $checkout->price }}"
                               readonly
                               required>
                        <h2 class="p-3 text-3xl">
                            Total cost: <span class="underline underline-offset-7">{{ $totalCost }}</span> CHF
                        </h2>
                        <input type="hidden" name="totalCost" value="{{ $totalCost }}">
                    </div>
                </div>
                <div class="bg-pearl-bush-200 p-8 rounded-tr-2xl w-full">
                    <h1 class="text-4xl font-bold mb-6 text-center">
                        Check apartment location</h1>
                    <div id="map" class="h-150 hover:ring-2 hover:ring-cognac-800 transition-all rounded-2xl"></div>
                    <input type="hidden" disabled name="latitude" id="latitude">
                    <input type="hidden" disabled name="longitude" id="longitude">
                    <input type="hidden" disabled name="address" id="address">
                </div>

                <div class="md:col-span-1 xl:col-span-2">
                    <button type="submit"
                            class="w-full h-15 bg-cognac-800 text-white text-xl p-3 rounded-b-2xl font-semibold hover:bg-cognac-900 transition">
                        Confirm booking
                    </button>
                </div>
            </form>
        </div>

        <script>
            window.onload = function () {
                const script = document.createElement("script");
                script.src = "https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_API_KEY') }}&libraries=places&callback=initMap";
                script.async = true;
                script.defer = true;
                document.head.appendChild(script);
            };
        </script>
        <script>
            function initMap() {
                const initialLocation = {lat: {{ $checkout->lat }}, lng: {{ $checkout->lon }}};
                const map = new google.maps.Map(document.getElementById("map"), {
                    center: initialLocation,
                    zoom: 14,
                });

                let marker = new google.maps.Marker({
                    position: initialLocation,
                    map: map,
                    draggable: false,
                });
            }
        </script>
</x-layout>
