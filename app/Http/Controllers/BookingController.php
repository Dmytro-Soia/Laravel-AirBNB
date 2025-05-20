<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutRequest;
use App\Http\Requests\StoreBookingRequest;
use App\Models\Apartment;
use App\Models\Booking;

use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function checkout(CheckoutRequest $request, Apartment $apartment)
    {
        $request->validate([]);
        $totalCost = $apartment->calculatePrice(Booking::daysDifference($request->reserved_at, $request->expired_at));
        session(['dateFrom' => $request->reserved_at]);
        session(['dateTo' => $request->expired_at]);
        session()->save();
        return view('/billing', ['checkout' => $apartment, 'totalCost' => $totalCost]);
    }

    public function booking (StoreBookingRequest $request, Apartment $apartment)
    {
        $totalCost = $apartment->calculatePrice(Booking::daysDifference(session('dateFrom'), session('dateTo')));
        if($totalCost != $request->totalCost){
            return redirect()->back()->withErrors(['message' => 'Difference between total costs!']);
        }
        $booking = new Booking([
            'reserved_at' => session('dateFrom'),
            'expired_at' => session('dateTo'),
            ]);
        $booking->apartment()->associate($apartment->id);
        $booking->tenant()->associate(Auth::user());

        $booking->save();
        session()->forget(['dateFrom', 'dateTo']);
        return redirect('/')->with('success', 'Booking has been created!');
    }
}
