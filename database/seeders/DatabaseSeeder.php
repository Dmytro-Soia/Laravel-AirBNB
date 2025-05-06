<?php

namespace Database\Seeders;

use App\Models\Apartment;
use App\Models\Booking;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()
            ->count(3)
            ->has(Apartment::factory()
                ->count(5))
            ->create();

        $users = User::all();
        $apartments = Apartment::all();

        $users->each(function ($user) use ($apartments) {
            Booking::factory()
                ->for($user, 'tenant')
                ->for($apartments->random(), 'apartment')
                ->create();
        });
    }
}
