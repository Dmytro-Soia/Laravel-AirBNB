<?php

namespace App\Http\Controllers;

use App\Models\Apartment;
use App\Models\Booking;
use Carbon\CarbonInterval;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function checkout(Request $request, $id)
    {
        if($request->dates === null){
            return back()->withErrors(['message' => 'Choose dates']);
        }
        $dates = explode(' to ',$request->dates);
        $dateFrom = $dates[0];
        $dateTo = $dates[1];
        $checkout = Apartment::where('id', $id)->firstOrFail();
        $totalCost = $checkout->calculatePrice(Booking::daysDifference($dateFrom, $dateTo));
        session(['dateFrom' => $dateFrom]);
        session(['dateTo' => $dateTo]);
        session()->save();
        return view('/billing', ['checkout' => $checkout, 'totalCost' => $totalCost]);
    }

    public function booking (Request $request, $id)
    {
        $checkout = Apartment::where('id', $id)->firstOrFail();
        $totalCost = $checkout->calculatePrice(Booking::daysDifference(session('dateFrom'), session('dateTo')));
        if($totalCost != $request->totalCost){
            return redirect()->back()->withErrors(['message' => 'Difference between total costs!']);
        }
        $request->validate([
            'title' => ['required', 'max:255'],
            'description' => ['required', 'max:300'],
            'rooms' => ['required', 'integer'],
            'max_people' => ['required', 'integer'],
            'price' => ['required', 'integer'],
        ]);
        // Create an apartment
        $booking = new Booking([
            'reserved_at' => session('dateFrom'),
            'expired_at' => session('dateTo'),
            ]);
        $booking->apartment()->associate($id);
        $booking->tenant()->associate(Auth::user());

        $booking->save();
        return redirect('/')->with('success', 'Booking has been created!');
    }
}
