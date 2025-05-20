<?php

namespace App\Http\Controllers;

use App\Models\Apartment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomePageController extends Controller
{
    public function search(Request $request)
    {
        $apartments = Apartment::with('images')
            ->when($request->city, fn($query)=>$query->where('city', '=', request('city')))
            ->when($request->min_price, fn($query)=>$query->where('price', '>=', request('min_price')))
            ->when($request->max_price, fn($query)=>$query->where('price', '<=', request('max_price')))
            ->when($request->rooms, fn($query)=>$query->where('rooms', '>=', request('rooms')))
            ->when($request->persons, fn($query)=>$query->where('max_people', '>=', request('persons')))->get();

        return view('home', ['apartments' => $apartments]);
    }
}
