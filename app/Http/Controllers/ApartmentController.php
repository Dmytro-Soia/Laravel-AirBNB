<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreApartmentsRequest;
use App\Http\Requests\UpdateApartmentsRequest;
use App\Models\Apartment;
use App\Models\Booking;
use App\Models\Image;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class ApartmentController extends Controller
{
    public function mostRented()
    {
        $treeMostRentedCities = Apartment::select('city', DB::raw('COUNT(bookings.id) as res_count'))
            ->join('bookings', 'apartments.id', '=', 'bookings.apartment_id')
            ->groupBy('city')
            ->orderByDesc('res_count')
            ->limit(3)
            ->get();

        $cities = $treeMostRentedCities->pluck('city');
        $allApartments = [];
        foreach ($cities as $city) {
            $apartments = Apartment::with('images')->withCount('bookings')->orderBy('bookings_count', 'desc')->where('city', $city)->limit(2)->get();

            $allApartments[$city] = $apartments;
        }
        $apartments = Apartment::with('images')->orderBy('created_at','desc')->get();

        return view('home', ['apartmentsMR' => $allApartments, 'apartments' => $apartments]);
    }

    public function create(StoreApartmentsRequest $request)
    {
        $apartment = new Apartment($request->validated());

        $apartment->owner()->associate(Auth::user());
        $apartment->save();

        foreach ($request->file('photos') as $photo)
        {
            $path = Storage::disk('public')->putFile('images', $photo);
            $image = new Image([
                'path' => $path
            ]);
            $apartment->images()->save($image);
        }
        return redirect('/');
    }

    public function detail(Apartment $apartment)
    {
        $weather = Cache::remember('weather_' . strtolower(trim($apartment->city)), 86400, function () use ($apartment) {
            $apiKey = config('services.google_api.key');
            $url = "https://weather.googleapis.com/v1/forecast/days:lookup?key=$apiKey&location.latitude=$apartment->lat&location.longitude=$apartment->lon&days=4";
            $response = Http::get($url);

            return $response->json();
        });
        $days = [];
        foreach ($weather['forecastDays'] as $day) {
            $date = Carbon::create($day['interval']['startTime']);
            $days[] = $date->rawFormat('F l-j');
        }
        $existedBookings = Booking::where('apartment_id', $apartment->id)->get();
        return view('details', [
            'apartment' => $apartment,
            'bookings' => $existedBookings,
            'weather' => $weather,
            'days' => $days]);
    }

    public function delete(Apartment $apartment)
    {
        Gate::authorize('user_is_owner', $apartment);
        $containedImages = Image::where('apartment_id', $apartment->id)->get();
        foreach($containedImages as $image)
        {
            Storage::disk('public')->delete('images/' . $image->path);
            $image->delete();
        }
        Booking::where('apartment_id', $apartment->id)->delete();
        $apartment->delete();
        return redirect('/');
    }

    public function edit_index(Apartment $apartment )
    {
        Gate::authorize('user_is_owner', $apartment);
        return view('edit', ['editApartment' => $apartment]);
    }

    public function edit(UpdateApartmentsRequest $request, Apartment $apartment)
    {
        Gate::authorize('user_is_owner', $apartment);
        $address = explode(', ', $request->address);

        $apartment->fill($request->validated());

        $apartment->save();

    if($request->hasFile('photos')) {
        foreach($apartment->images as $image)
        {
            Storage::disk('public')->delete('images/' . $image->path);
        }
        $apartment->images()->delete();
        foreach ($request->file('photos') as $photo)
        {
            $path = Storage::disk('public')->putFile('images', $photo);
            $image = new Image([
                'path' => $path
            ]);
            $apartment->images()->save($image);
        }
    }
        return redirect('/');
    }
}
