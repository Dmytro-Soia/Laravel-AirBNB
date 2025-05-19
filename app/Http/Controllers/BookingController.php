<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutRequest;
use App\Http\Requests\StoreBookingRequest;
use App\Models\Apartment;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function checkout(CheckoutRequest $request, $id)
    {
        $request->validate([

        ]);
        $checkout = Apartment::where('id', $id)->firstOrFail();
        $totalCost = $checkout->calculatePrice(Booking::daysDifference($request->reserved_at, $request->expired_at));
        session(['dateFrom' => $request->reserved_at]);
        session(['dateTo' => $request->expired_at]);
        session()->save();
        return view('/billing', ['checkout' => $checkout, 'totalCost' => $totalCost]);
    }

    public function booking (StoreBookingRequest $request, $id)
    {
        $checkout = Apartment::where('id', $id)->firstOrFail();
        $totalCost = $checkout->calculatePrice(Booking::daysDifference(session('dateFrom'), session('dateTo')));
        if($totalCost != $request->totalCost){
            return redirect()->back()->withErrors(['message' => 'Difference between total costs!']);
        }

        $booking = new Booking([
            'reserved_at' => session('dateFrom'),
            'expired_at' => session('dateTo'),
            ]);
        $booking->apartment()->associate($id);
        $booking->tenant()->associate(Auth::user());

        $booking->save();
        session()->flush();
        return redirect('/')->with('success', 'Booking has been created!');
    }
}
