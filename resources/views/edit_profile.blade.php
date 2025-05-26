<x-layout>
    <x-slot:title>
        Edit profile
    </x-slot:title>
    <div class="flex justify-center items-center h-full">
        <form action="{{ route('user.edited_profile', $user->id) }}" method="post" class="border-border-grey border shadow-2xl px-8 py-6 rounded-2xl  bg-pearl-bush-200 flex items-center flex-col space-y-7 mb-40" enctype="multipart/form-data">
           @csrf
            <h2 class="text-3xl">Edit account</h2>
            <div class="flex flex-col space-y-5 w-lg">
                <label class="text-l" for="email">New username</label>
                <input class="border-1 rounded-2xl border-neutral-500 pl-2" type="text" value="{{$user->name}}" name="name">
                <label class="text-l" for="email">New email</label>
                <input class="border-1 rounded-2xl border-neutral-500 pl-2" type="text" value="{{$user->email}}" name="email">
                <label class="text-l" for="prof_pic">New profile picture</label>
                <input class="border-1 rounded-2xl border-neutral-500 pl-2 bg-white" type="file" name="prof_pic">
            </div>
            <button class="px-4 py-1 rounded-2xl w-full h-15 text-white bg-cognac-800 hover:bg-cognac-900" type="submit">Edit</button>
        </form>
    </div>
</x-layout>
