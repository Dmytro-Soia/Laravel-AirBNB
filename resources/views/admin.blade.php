<x-layout>
    <x-slot:title>
        Admin panel
    </x-slot:title>
    <div class="flex flex-wrap">
        @foreach($users as $user)
            <a href="{{ route('userprofile.user', $user )}}">
            <div class="flex flex-col ring-2 ring-cognac-800 rounded-2xl bg-pearl-bush-100 px-2 py-1 m-5 min-w-103 space-y-1">
                @if(isset($user->profile_img))
                <img src="{{ url('storage/images/' . $user->profile_img) }}"
                     class="block h-45 w-45 rounded-full self-center object-cover mb-3">
                @else
                    <div class="text-8xl flex justify-center items-center self-center font-bold w-45 h-45 text-cognac-800 mb-3">{{$user->profile_img}}{{strtoupper(mb_substr($user->name, 0,1))}}</div>
                @endif
                <p class="text-xl">Username: {{ $user->name }}</p>
                <p class="text-xl">Email: {{ $user->email }}</p>
                <p class="text-xl">Admin:
                    @if($user->admin)
                        <span class="text-green-600 font-bold">true</span>
                    @else
                        <span class="text-red-600 font-bold">false</span>
                    @endif
                </p>
                <form method="post" action="{{ route('adminpanel.changeStatus', $user->id) }}">
                    @csrf
                    <input type="hidden" value="{{$user->id}}" name="id">
                    <button type="submit" class="flex justify-center w-full mt-3 mb-2 bg-cognac-800 text-white rounded-2xl text-xl py-1">Change role</button>
                </form>
            </div>
            </a>
        @endforeach
    </div>
</x-layout>
