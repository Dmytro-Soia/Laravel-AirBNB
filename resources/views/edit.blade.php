<x-layout>
    <x-slot:title>
        Rent a house
    </x-slot:title>
    <div class="w-3/4 h-full m-auto place-content-center">
        <form class="grid xl:grid-cols-2 md:grid-cols-1 md:mt-10 md:gap-10 xl:gap-0 px-6 py-4 mb-24">
            <div class="bg-pearl-bush-200 rounded-tl-2xl p-8 w-full">
                <h1 class="text-4xl font-bold mb-6 text-center">
                    Edit information</h1>
                <div class="flex flex-col gap-4">
                    <input type="text" name="title" id="title"
                           class="border-gray-500 transition-all focus:outline-none focus:ring-2 focus:ring-cognac-800 border-1 rounded p-3"
                           required>
                    <textarea name="content"
                              class="border-1 rounded p-3 border-gray-500 transition-all focus:outline-none focus:ring-2 focus:ring-cognac-800 resize-none"
                              rows="4">
                    </textarea>
                    <input type="number" name="rooms" id="rooms" min="1"
                           class="border-1 rounded p-3 border-gray-500 transition-all focus:outline-none focus:ring-2 focus:ring-cognac-800"
                           required>
                    <input type="number" name="peoples" id="peoples"
                           min="1"
                           class="border-1 rounded p-3 border-gray-500 transition-all focus:outline-none focus:ring-2 focus:ring-cognac-800"
                           required>
                    <input type="number" name="price" id="price"
                           class="border-1 rounded p-3 border-gray-500 transition-all focus:outline-none focus:ring-2 focus:ring-cognac-800"
                           required>
                    <input type="file" name="photo" id="photo"
                           class="border-1 rounded p-3 border-gray-500 bg-white transition-all focus:outline-none focus:ring-2 focus:ring-cognac-800 text-placeholders"
                           multiple required>
                </div>
            </div>
            <div class="bg-pearl-bush-200 p-8 rounded-tr-2xl w-full">
                <h1 class="text-4xl font-bold mb-6 text-center">
                    Choose location</h1>
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d21959.20473994736!2d6.631473949999999!3d46.5298689!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2sch!4v1746184541484!5m2!1sen!2sch"
                    class="rounded-3xl w-full h-113" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
            <div class="md:col-span-1 xl:col-span-2">
                <button type="submit"
                        class="w-full h-15 bg-cognac-800 text-white p-3 rounded-b-2xl font-semibold hover:bg-cognac-900 transition">
                    Confirm
                </button>
            </div>
        </form>
    </div>
</x-layout>
