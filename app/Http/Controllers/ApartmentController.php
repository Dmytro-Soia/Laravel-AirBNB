<?php

namespace App\Http\Controllers;

use App\Models\Apartment;
use App\Models\Booking;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ApartmentController extends Controller
{
    public function create(Request $request)
    {
        $request->validate([
            'title' => ['required', 'max:255'],
            'description' => ['required', 'max:300'],
            'rooms' => ['required', 'integer'],
            'max_people' => ['required', 'integer'],
            'price' => ['required', 'integer'],
            'photos' => ['required', 'array'],
            'photos.*' => ['image', 'mimes:jpeg,png,jpg', 'max:10240'],
            'longitude' => ['required'],
            'latitude' => ['required'],
            'address' => ['required'],
        ]);

        $address = $request->input('address');
        $address = str_replace(', ', ',', $address);
        $address = explode(',', $address);
        $city = explode(' ', $address[1]);

        // Create an apartment
        $apartment = new Apartment([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'max_people' => $request->input('max_people'),
            'rooms' => $request->input('rooms'),
            'price' => $request->input('price'),
            'lon' => $request->input('longitude'),
            'lat' => $request->input('latitude'),
        ]);
        $apartment->country = $address[2];
        $apartment->city = $city[1];
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
        $chosenApartment = Apartment::where('id',$id)->with('images')->firstOrFail();
        $existedBookings = Booking::where('apartment_id', $id)->get();
        return view('details', ['apartment' => $chosenApartment, 'bookings' => $existedBookings]);
    }

    public function delete($id)
    {
        $containedImages = Image::where('apartment_id', $id)->get();
        foreach($containedImages as $image)
        {
            Storage::disk('public')->delete('images/' . $image->path);
            $image->delete();
        }
        $apartment = Apartment::where('id', $id)->delete();
        return redirect('/');
    }

    public function edit_index( $id)
    {
        $editaibleApartment = Apartment::where('id',$id)->with('images')->first();

        return view('edit', ['editApartment' => $editaibleApartment]);
    }

    public function edit(Request $request, $id)
    {
        $request->validate([
            'title' => ['required', 'max:255'],
            'description' => ['required', 'max:300'],
            'rooms' => ['required', 'integer'],
            'max_people' => ['required', 'integer'],
            'price' => ['required', 'integer'],
            'photos' => ['array'],
            'photos.*' => ['image', 'mimes:jpeg,png,jpg', 'max:10240'],
            'longitude' => [''],
            'latitude' => [''],
            'address' => ['required'],
        ]);

        $apartToEdit = Apartment::where('id', $id)->with('images')->first();

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
