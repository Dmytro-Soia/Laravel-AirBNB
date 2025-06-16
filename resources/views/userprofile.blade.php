<x-layout>
    <x-slot:title>
        {{ $user->name }}'s Profile
    </x-slot:title>

    <div class="flex">
        <div class="flex flex-col w-full p-8 h-screen">
            <section id="properties" class="mb-12 w-9/10">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-cognac-800 ml-6">
                        @auth
                            @if($user->id === auth()->user()->id)
                                My Properties
                            @else
                                {{ $user->name }}'s Properties
                            @endif
                        @endauth
                    </h2>
                </div>
                <div class="grid grid-cols-3 gap-8">
                    @foreach($apartments as $apartment)
                        <div id="default-carousel" class="relative w-9/10 hover:shadow-md rounded-3xl bg-white group"
                             data-carousel="static">
                            <!-- Carousel wrapper -->
                            <div class="relative h-96 overflow-hidden rounded-t-3xl z-15 hover:z-14">
                                <!-- Items -->
                                @foreach($apartment->images as $image)
                                    <div class="hidden duration-700 ease-in-out z-14 group-hover:z-14"
                                         data-carousel-item>
                                        <img src="{{ url('storage/' . $image->path) }}"
                                             class="absolute w-full block h-96 object-cover"
                                             alt="Carousel image">
                                    </div>
                                @endforeach
                            </div>
                            <!-- Slider indicators -->
                            <div
                                class="absolute z-17 flex -translate-x-1/2 bottom-27 left-1/2 space-x-3 rtl:space-x-reverse">
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
                                    class="absolute top-45 start-0 z-17 flex items-center justify-center h-1/10 px-4 cursor-pointer opacity-0 group-hover:opacity-100  transition-opacity duration-400 focus:outline-none"
                                    data-carousel-prev>
                                <span
                                    class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-white hover:scale-105 hover:opacity-100 opacity-70 transition-all group-focus:outline-none">
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
                                    class="absolute  top-45 end-0 z-17 flex items-center justify-center h-1/10 px-4 cursor-pointer opacity-0 group-hover:opacity-100 transition-opacity duration-400  focus:outline-none"
                                    data-carousel-next>
                                <span
                                    class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-white hover:scale-105 hover:opacity-100 opacity-70 transition-all group-focus:outline-none">
                                    <svg class="w-2.5 h-2.5 text-black" aria-hidden="true"
                                         xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 4 10">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                              stroke-width="2"
                                              d="m1 9 4-4-4-4"/>
                                    </svg>
                                    <span class="sr-only">Next</span>
                                </span>
                            </button>
                            <a href="{{ url('detail/' . $apartment->id) }}" class="w-full block">
                                <div class="flex w-full justify-between items-start mb-3 p-4">
                                    <div class="flex flex-col w-full">
                                        <h3 class="font-semibold text-cognac-800 w-full">{{ $apartment->title }}</h3>
                                        <p class="text-cognac-700 mt-1">{{ $apartment->price }} CHF/night</p>
                                    </div>
                                    @auth()
                                        @if($user->id === auth()->user()->id)
                                    <div class="flex gap-2">
                                        <a href="{{ url('edit/' . $apartment->id) }}"
                                           class="px-3 py-1 bg-pearl-bush-100 text-cognac-800 rounded hover:bg-pearl-bush-200 transition-colors">
                                            Edit
                                        </a>
                                        <form method="POST" action="{{ url('delete/' . $apartment->id) }}"
                                              class="inline">
                                            @csrf
                                            <button type="submit"
                                                    class="px-3 py-1 bg-red-100 text-red-600 rounded hover:bg-red-200 transition-colors">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                            @endif
                                    @endauth
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </section>
            @auth
            @if($user->id === auth()->user()->id)
                <section id="bookings" class="w-9/10">
                    <h2 class="text-2xl font-bold text-cognac-800 mb-6 ml-6">My Bookings</h2>
                    <div class="space-y-4 w-29/30">
                        @foreach($bookings as $booking)
                            <div class="bg-white rounded-xl p-4 hover:shadow-md transition-shadow mb-3">
                                <a href="{{ url('detail/' . $booking->apartment_id) }}">
                                    <div class="flex flex-row items-center justify-between">
                                        <div class="flex flex-col">
                                            <h3 class="font-semibold text-cognac-800">{{ $booking->apartment->title }}</h3>
                                            <h3 class="font-semibold text-cognac-800">{{ $booking->apartment->country }}
                                                , {{ $booking->apartment->city }}
                                                , {{ $booking->apartment->street }}</h3>
                                        </div>
                                        <div class="flex flex-col">
                                            <h3 class="font-semibold text-cognac-800">Reserved
                                                at: {{ date('Y-m-d', strtotime($booking->reserved_at)) }}</h3>
                                            <h3 class="font-semibold text-cognac-800">Expired at:
                                                &nbsp;&nbsp;&nbsp;{{ date('Y-m-d', strtotime($booking->expired_at))}}</h3>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </section>
        </div>
        @endif
        @endauth
        <div
            class="min-w-66 max-w-80 bg-cognac-800 text-white p-6 space-y-8 fixed right-0 h-full inset-y-0 mt-25">
            <div class="flex flex-col items-center space-y-4">
                <div class="w-35 h-35 bg-pearl-bush-100 rounded-full flex items-center justify-center">
                    @if(isset($user->profile_img))
                        <img src="{{ url('storage/images/' . $user->profile_img) }}"
                             class="h-full rounded-full object-cover">
                    @else
                        <p class="text-6xl font-bold text-cognac-800">{{$user->profile_img}}{{strtoupper(mb_substr($user->name, 0,1))}}</p>
                    @endif
                </div>
                <div class="text-center">
                    <h2 class="font-bold text-4xl break-all">{{ $user->name }}</h2>
                    <p class="text-xl opacity-75 break-all">{{ $user->email }}</p>
                </div>
            </div>

            <nav class="mt-5 space-y-2">
                @auth
                @if($user->id === auth()->user()->id)
                    <a href="#properties" class="block px-4 py-2 rounded-lg hover:bg-cognac-900 transition">
                        My Properties
                    </a>
                    <a href="#bookings" class="block px-4 py-2 rounded-lg hover:bg-cognac-900 transition">
                        My Bookings
                    </a>
                @endif
                @if($user->id === auth()->user()->id || auth()->user()->admin)
                    <form method="GET" action='{{ route('user.edit_profile', $user->id)}}' class="mt-auto">
                        <button type="submit"
                                class="w-full px-4 py-2 rounded-lg bg-cognac-900 hover:bg-cognac-950 transition">
                            Edit
                        </button>
                    </form>
                    <form method="POST" action='{{ route('user.delete_profile', $user->id)}}' class="mt-auto">
                        @csrf
                        <button type="submit"
                                class="w-full px-4 py-2 rounded-lg bg-cognac-900 hover:bg-cognac-950 transition">
                            Delete
                        </button>
                    </form>
                @endif
                @if($user->id === auth()->user()->id)
                    <form method="POST" action='{{ route('user.logout') }}' class="mt-auto">
                        @csrf
                        <button type="submit"
                                class="w-full px-4 py-2 rounded-lg bg-cognac-900 hover:bg-cognac-950 transition">
                            Logout
                        </button>
                    </form>
                @endif
                @endauth
            </nav>
        </div>
    </div>
</x-layout>
