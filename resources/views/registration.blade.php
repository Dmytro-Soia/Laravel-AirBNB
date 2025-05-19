<x-layout>
    <x-slot:title>
        Registration
    </x-slot:title>
    <div class="flex justify-center items-center h-full">
        <form action="{{ route('registered') }}" method="post" class="border-border-grey border shadow-2xl px-8 py-6 rounded-2xl  bg-pearl-bush-200 flex items-center flex-col space-y-7 mb-40">
            <h2 class="text-3xl">Register your account</h2>
            <div class="flex flex-col space-y-5 w-lg">
                @csrf
                <label class="text-l" for="name">Username</label>
                <input class="border-1 rounded-2xl border-neutral-500 pl-2" value="{{ old("name") }}" type="text" name="name">
                <label class="text-l" for="email">Email</label>
                <input class="border-1 rounded-2xl border-neutral-500 pl-2" value="{{ old("email") }}" type="text" name="email">
                <label class="text-l" for="password">Password</label>
                <input class="border-1 rounded-2xl border-neutral-500 pl-2" type="password" name="password">
                <label class="text-l" for="password_confirmation">Password</label>
                <input class="border-1 rounded-2xl border-neutral-500 pl-2" type="password" name="password_confirmation">
            </div>
            <button class="px-4 py-1  rounded-2xl w-full h-15 text-white bg-cognac-800 hover:bg-cognac-900" type="submit">Register</button>
            <p class="text-xl">Or <a href="login" class="text-cognac-900 hover:underline">Login</a> to your account</p>
        </form>

    </div>
</x-layout>
