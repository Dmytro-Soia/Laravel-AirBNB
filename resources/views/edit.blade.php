<x-layout>
    <x-slot:title>
        Rent a house
    </x-slot:title>
    <div class="w-3/4 h-full m-auto place-content-center">
        <form action="/edit/{{ $editApartment->id }}" method="post" enctype="multipart/form-data"
              class="grid xl:grid-cols-2 md:grid-cols-1 md:mt-10 md:gap-10 xl:gap-0 px-6 py-4 mb-24">
            @csrf
            <div class="bg-pearl-bush-200 rounded-tl-2xl p-8 w-full">
                <h1 class="text-4xl font-bold mb-6 text-center">
                    Edit information</h1>
                <div class="flex flex-col gap-4">
                    <input type="text" name="title" id="title"
                           placeholder="Name apartment"
                           class="border-gray-500 transition-all focus:outline-none focus:ring-2 focus:ring-cognac-800 border-1 rounded p-3"
                           value="@if(request()->is('post')) {{ old('title') }} @else {{$editApartment->title}}@endif"
                           required>
                    <textarea name="description" placeholder="Description" class="border-1 rounded p-3 border-gray-500 transition-all focus:outline-none focus:ring-2 focus:ring-cognac-800 resize-none" rows="4" required>@if(request()->is('post')) {{ old('description') }} @else {{$editApartment->description}}@endif</textarea>
                    <input type="number" name="rooms" id="rooms" min="1" placeholder="Rooms"
                           class="border-1 rounded p-3 border-gray-500 transition-all focus:outline-none focus:ring-2 focus:ring-cognac-800"
                           value="@if(request()->is('post')){{old('rooms')}}@else{{$editApartment->rooms}}@endif"
                           required>
                    <input type="number" name="max_people" id="peoples"
                           min="1" placeholder="Max people"
                           class="border-1 rounded p-3 border-gray-500 transition-all focus:outline-none focus:ring-2 focus:ring-cognac-800"
                           value="@if(request()->is('post')){{old('max_people')}}@else{{$editApartment->max_people}}@endif"
                           required>
                    <input type="number" name="price" id="price"
                           placeholder="Price"
                           class="border-1 rounded p-3 border-gray-500 transition-all focus:outline-none focus:ring-2 focus:ring-cognac-800"
                           value="@if(request()->is('post')){{old('price')}}@else{{$editApartment->price}}@endif"
                           required>
                    <input type="file" name="photos[]" id="photo"
                           class="border-1 rounded p-3 bg-white border-gray-500 transition-all focus:outline-none focus:ring-2 focus:ring-cognac-800 text-placeholders"
                           multiple>
                </div>
            </div>
            <div class="bg-pearl-bush-200 p-8 rounded-tr-2xl w-full">
                <h1 class="text-4xl font-bold mb-6 text-center">
                    Choose location</h1>
                <div id="map" class="h-117 hover:ring-2 hover:ring-cognac-800 transition-all rounded-2xl"></div>
                <input type="hidden" name="lat" value="{{$editApartment->lat}}" id="latitude" required>
                <input type="hidden" name="lon" value="{{$editApartment->lon}}" id="longitude" required>
                <input type="hidden" name="address" value="{{$editApartment->country}}, {{$editApartment->city}}, {{$editApartment->street}}" id="address" required>
            </div>

            <div class="md:col-span-1 xl:col-span-2">
                <button type="submit" class="w-full h-15 bg-cognac-800 text-white p-3 rounded-b-2xl font-semibold hover:bg-cognac-900 transition">
                    Confirm
                </button>
            </div>
        </form>
    </div>

    <script>
        window.onload = function() {
            const script = document.createElement("script");
            script.src = "https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_API_KEY') }}&libraries=places&callback=initMap";
            script.async = true;
            script.defer = true;
            document.head.appendChild(script);
        };
    </script>
    <script>
        function initMap() {
            const initialLocation = { lat: {{$editApartment->lat}}, lng: {{$editApartment->lon}} };
            const map = new google.maps.Map(document.getElementById("map"), {
                center: initialLocation,
                zoom: 10,
            });

            let marker = new google.maps.Marker({
                position: initialLocation,
                map: map,
                draggable: true,
            });

            const geocoder = new google.maps.Geocoder();

            map.addListener("click", (event) => {
                const latLng = event.latLng;
                marker.setPosition(latLng);
                updateLocationFields(latLng, geocoder);
            });

            marker.addListener("dragend", () => {
                updateLocationFields(marker.getPosition(), geocoder);
            });

            function updateLocationFields(location, geocoder) {
                const lat = location.lat();
                const lng = location.lng();
                document.getElementById("latitude").value = lat;
                document.getElementById("longitude").value = lng;

                geocoder.geocode({ location: location }, (results, status) => {
                    if (status === "OK" && results[0]) {
                        const components = results[0].address_components;
                        let street = "";
                        let city = "";
                        let country = "";

                        components.forEach(component => {
                            const types = component.types;
                            if (types.includes("route")) {
                                street = component.long_name;
                            }
                            if (types.includes("locality") || types.includes("administrative_area_level_2")) {
                                city = component.long_name;
                            }
                            if (types.includes("country")) {
                                country = component.long_name;
                            }
                        });

                        const address = `${street}, ${city}, ${country}`;
                        document.getElementById("address").value = address;
                        console.log("Address:", address);
                    } else {
                        console.error("Geocoder failed:", status);
                    }
                });
            }

            updateLocationFields(initialLocation, geocoder);
        }
    </script>
</x-layout>
