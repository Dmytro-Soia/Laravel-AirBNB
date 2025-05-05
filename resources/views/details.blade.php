<x-layout>
    <x-slot:title>
        Rooms
    </x-slot:title>
    <h1 class="text-4xl mb-3 ml-15">Title</h1>
    <div class="grid grid grid-cols-[70%_30%] grid-rows-2h-full">
        <div id="test-carousel" class="h-4/5 mx-10">
            <div id="default-carousel" class="relative" data-carousel="slide">
                <!-- Carousel wrapper -->
                <div class="relative h-200 z-10 overflow-hidden rounded-3xl">
                    <!-- Item 1 -->
                    <div class="hidden duration-700 ease-in-out" data-carousel-item>
                        <img src="/images/a.avif"
                             class="absolute z-10 block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2"
                             alt="...">
                    </div>
                    <!-- Item 2 -->
                    <div class="hidden duration-700 ease-in-out" data-carousel-item>
                        <img src="/images/aa.avif"
                             class="absolute z-10 block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2"
                             alt="...">
                    </div>
                    <!-- Item 3 -->
                    <div class="hidden duration-700 ease-in-out" data-carousel-item>
                        <img src="/images/b.avif"
                             class="absolute z-10 block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2"
                             alt="...">
                    </div>
                </div>
                <!-- Slider indicators -->
                <div class="absolute z-30 flex -translate-x-1/2 bottom-5 left-1/2 space-x-3 rtl:space-x-reverse">
                    <button type="button" class="w-3 h-3 rounded-full" aria-current="true" aria-label="Slide 1"
                            data-carousel-slide-to="0"></button>
                    <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 2"
                            data-carousel-slide-to="1"></button>
                    <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 3"
                            data-carousel-slide-to="2"></button>
                </div>
                <!-- Slider controls -->
                <button type="button"
                        class="absolute top-50 start-0 z-15 flex items-center justify-center h-1/2 px-4 cursor-pointer group focus:outline-none"
                        data-carousel-prev>
        <span
            class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
            <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true"
                 xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M5 1 1 5l4 4"/>
            </svg>
            <span class="sr-only">Previous</span>
        </span>
                </button>
                <button type="button"
                        class="absolute top-50 end-0 z-15 flex items-center justify-center h-1/2 px-4 cursor-pointer group focus:outline-none"
                        data-carousel-next>
        <span
            class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
            <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true"
                 xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="m1 9 4-4-4-4"/>
            </svg>
            <span class="sr-only">Next</span>
        </span>
                </button>
            </div>

        </div>
        <div class="row-span-2 h-full ml-10">
            <form class="flex shadow-2xl flex-col h-full justify-between border-border-grey w-full rounded-4xl space-x-10">
                <div class="flex flex-row m-auto space-x-10 my-10">
                    <div id="datepicker-inlinee" class="text-center " inline-datepicker data-date="02/25/2024">
                        From
                    </div>
                    <div id="datepicker-inline" inline-datepicker data-date="03/25/2024">
                        To
                    </div>
                </div>
                <div class="flex flex-col w-4/13 space-y-10 px-6 py-4 w-full items-start">
                    <h2 class="text-center text-2xl underline">123 CHF per night</h2>
                    <h2 class="text-center text-2xl underline">Developer fee: 1000 CHF </h2>
                    <input type="number" class="w-full transition-all border-border-grey focus:ring-2 focus:ring-cognac-800 focus:outline-none rounded-2xl " placeholder="Number of guests" max="15">
                    <h2 class="text-center text-2xl mt-70 underline">Total cost: 12345678</h2>
                    <button class="w-full  h-20 rounded-3xl bg-cognac-800 hover:bg-cognac-900 transition-colors text-white" type="submit">Rent a house</button>
                </div>
            </form>
        </div>
        <div class=" w-full">
            <textarea rows="12" disabled  class="resize-none mt-10 w-full rounded-2xl ring-2 ring-cognac-800 pr-5"></textarea>
        </div>
    </div>
</x-layout>
