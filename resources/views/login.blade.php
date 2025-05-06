<x-layout>
    <x-slot:title>
        Login
    </x-slot:title>
    <div class="flex justify-center items-center h-full">
        <form action="{{ route('authorised') }}" method="post" class="border-border-grey border shadow-2xl px-8 py-6 rounded-2xl  bg-pearl-bush-200 flex items-center flex-col space-y-7 mb-40">
           @csrf
            <h2 class="text-3xl">Login to your account</h2>
            <div class="flex flex-col space-y-5 w-lg">
                <label class="text-l" for="email">Email</label>
                <input class="border-1 rounded-2xl border-neutral-500 pl-2" type="text" name="email">
                <label class="text-l" for="password">Password</label>
                <input class="border-1 rounded-2xl border-neutral-500 pl-2" type="password" name="password">
            </div>
            <button class="px-4 py-1 rounded-2xl w-full h-15 text-white bg-cognac-800 hover:bg-cognac-900" type="submit">Login</button>
            <p class="text-xl">Or <a href="register" class="text-cognac-900 hover:underline">Register</a> new account</p>
        </form>
    </div>
</x-layout>
