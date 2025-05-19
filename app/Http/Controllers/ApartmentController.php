<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreApartmentsRequest;
use App\Models\Apartment;
use App\Models\Booking;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ApartmentController extends Controller
{
    public function create(StoreApartmentsRequest $request)
    {
        $address = explode(', ', $request->address);

        // Create an apartment
        $apartment = new Apartment($request->validated());
        $apartment->country = $address[2];
        $apartment->city = $address[1];
        $apartment->street = $address[0];

        $apartment->owner()->associate(Auth::user());

        $apartment->save();

        foreach ($request->file('photos') as $photo)
        {
            $photoName = Str::uuid()->toString() . '.' . $photo->getClientOriginalExtension();
            Storage::disk('public')->putFileAs('images', $photo, $photoName);
            $photo = new Image();
            $photo->path = $photoName;
            $apartment->images()->save($photo);
        }
        return redirect('/');
    }

    public function detail($id)
    {
        $chosenApartment = Apartment::getApartment($id);
        $existedBookings = Booking::where('apartment_id', $id)->get();
        return view('details', ['apartment' => $chosenApartment, 'bookings' => $existedBookings]);
    }

    public function delete($id)
    {
        if(!Gate::allows('user_is_owner', Apartment::getApartment($id))) {
            return redirect()->back()->withErrors(['message'=> 'You dont have rights to do this action']);
        }
        $containedImages = Image::where('apartment_id', $id)->get();
        foreach($containedImages as $image)
        {
            Storage::disk('public')->delete('images/' . $image->path);
            $image->delete();
        }
        $apartment = Apartment::getApartment($id)->delete();
        return redirect('/');
    }

    public function edit_index( $id)
    {
        $editableApartment = Apartment::getApartment($id);
        if(!Gate::allows('user_is_owner', $editableApartment)) {
            return redirect()->back()->withErrors(['message'=> 'You dont have rights to do this action']);
        }
        return view('edit', ['editApartment' => $editableApartment]);
    }

    public function edit(Request $request, $id)
    {
        $request->validate([
            'title' => ['required', 'max:255'],
            'description' => ['required', 'max:300'],
            'rooms' => ['required', 'integer'],
            'max_people' => ['required', 'integer'],
            'price' => ['required', 'integer'],
            'photos' => ['array', 'min:3'],
            'photos.*' => ['image', 'mimes:jpeg,png,jpg', 'max:10240'],
            'longitude' => [''],
            'latitude' => [''],
            'address' => ['required'],
        ]);

        $apartToEdit = Apartment::getApartment($id);
        if(!Gate::allows('user_is_owner', $apartToEdit)) {
            return redirect()->back()->withErrors(['message'=> 'You dont have rights to do this action']);
        }
        $address = $request->input('address');
        $address = str_replace(', ', ',', $address);
        $address = explode(',', $address);
        $city = explode(' ', $address[1]);


        $apartToEdit->title =  $request->input('title');
        $apartToEdit->description = $request->input('description');
        $apartToEdit->max_people = $request->input('max_people');
        $apartToEdit->rooms = $request->input('rooms');
        $apartToEdit->price = $request->input('price');
        $apartToEdit->lon = $request->input('longitude');
        $apartToEdit->lat = $request->input('latitude');

        $apartToEdit->country = $address[2];
        $apartToEdit->city = $city[1];
        $apartToEdit->street = $address[0];

        $apartToEdit->save();

    if($request->hasFile('photos')) {
        foreach($apartToEdit->images as $image)
        {
            Storage::disk('public')->delete('images/' . $image->path);
        }
        $apartToEdit->images()->delete();
        foreach ($request->file('photos') as $photo)
        {
            $photoName = Str::uuid()->toString() . '.' . $photo->getClientOriginalExtension();
            Storage::disk('public')->putFileAs('images', $photo, $photoName);
            $photo = new Image();
            $photo->path = $photoName;
            $apartToEdit->images()->save($photo);
        }
    }
        return redirect('/');
    }
}
