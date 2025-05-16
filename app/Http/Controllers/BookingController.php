<?php

namespace App\Http\Controllers;

use App\Models\Apartment;
use App\Models\Booking;
use App\Rules\DateValidation;
use Carbon\CarbonInterval;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function checkout(Request $request, $id)
    {
        $request->validate([
            'dates' => [new DateValidation()],
            'guest_number' => ['required', 'integer', 'min:1'],
        ]);
        $checkout = Apartment::where('id', $id)->firstOrFail();
        $totalCost = $checkout->calculatePrice(Booking::daysDifference($request->reserved_at, $request->expired_at));
        session(['dateFrom' => $request->reserved_at]);
        session(['dateTo' => $request->expired_at]);
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
        session()->flush();
        return redirect('/')->with('success', 'Booking has been created!');
    }
}
