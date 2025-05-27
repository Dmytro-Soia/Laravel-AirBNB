<?php

namespace Database\Seeders;

use App\Models\Apartment;
use App\Models\Booking;
use App\Models\Image;
use App\Models\User;
use Database\Factories\ImageFactory;
use Illuminate\Database\Seeder;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        User::factory([
            'email' => 'test@test.com',
            'password' => 'password',
        ])->create();

        User::factory()
            ->count(10)
            ->has(Apartment::factory()
                ->has(Image::factory()->count(5))
                ->count(5))
            ->create();
//
//        $users = User::all();
//        $apartments = Apartment::all();
//
//        $users->each(function ($user) use ($apartments) {
//            Booking::factory()
//                ->for($user, 'tenant')
//                ->for($apartments->random(), 'apartment')
//                ->create();
//        });
    }
}
