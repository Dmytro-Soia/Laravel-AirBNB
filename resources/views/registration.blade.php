<x-layout>
    <x-slot:title>
        Registration
    </x-slot:title>
    <div class="flex justify-center items-center h-full">
        <form class="border-border-grey border shadow-2xl px-8 py-6 rounded-2xl  bg-pearl-bush-200 flex items-center flex-col space-y-7 mb-40">
            <h2 class="text-3xl">Register your account</h2>
            <div class="flex flex-col space-y-5 w-lg">
                <label class="text-l" for="username">Username</label>
                <input class="border-1 rounded-2xl border-neutral-500 pl-2" type="text" name="Username">
                <label class="text-l" for="Email">Email</label>
                <input class="border-1 rounded-2xl border-neutral-500 pl-2" type="text" name="Email">
                <label class="text-l" for="Password">Password</label>
                <input class="border-1 rounded-2xl border-neutral-500 pl-2" type="text" name="Password">
            </div>
            <button class="px-4 py-1  rounded-2xl w-full h-15 text-white bg-cognac-800 hover:bg-cognac-900" type="submit">Register</button>
            <p class="text-xl">Or <a href="login" class="text-cognac-900 hover:underline">Login</a> to your account</p>
        </form>

    </div>
</x-layout>
