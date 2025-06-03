<?php

namespace App\Http\Controllers;

use App\Models\Apartment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class HomePageController extends Controller
{
    public function search(Request $request)
    {
        $events = null;
        if ($request->filled('city')) {
            $events = Cache::remember('events_' . strtolower(trim($request->city)), 604800, function () use ($request) {
                $apiKey = config('services.serp_api.key');
                $url = "https://serpapi.com/search.json?engine=google_events&q=Events+in+{$request->city}&google_domain=google.com&gl=us&hl=en&api_key=$apiKey";
                $response = Http::get($url);

                return array_slice($response->json()['events_results'], 0,8);
            });
        }
        $apartments = Apartment::with('images')
            ->when($request->city, fn($query)=>$query->where('city', '=', request('city')))
            ->when($request->min_price, fn($query)=>$query->where('price', '>=', request('min_price')))
            ->when($request->max_price, fn($query)=>$query->where('price', '<=', request('max_price')))
            ->when($request->rooms, fn($query)=>$query->where('rooms', '>=', request('rooms')))
            ->when($request->persons, fn($query)=>$query->where('max_people', '>=', request('persons')))->orderBy('created_at', 'desc')->get();

        return view('home', ['apartments' => $apartments, 'events' => $events]);
    }
}
