<?php

namespace App\Http\Controllers;

use App\Models\Apartment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
            'address' => ['required'],
        ]);

        $address = $request->input('address');
        $address = str_replace(', ', ',', $address);
        $address = explode(',', $address);

        $photoNames = [];
        foreach ($request->file('photos') as $photo)
        {
            $photoName = bin2hex(random_bytes(10)) . '.' . $photo->getClientOriginalExtension();
            $photoNames[] = $photoName;
            Storage::disk('public')->putFileAs('images', $photo, $photoName);
        }
        $photos = implode(',', $photoNames);

        $apartment = new Apartment();
        $apartment->title = $request->input('title');
        $apartment->description = $request->input('description');
        $apartment->rooms = (int) $request->input('rooms');
        $apartment->max_people = (int) $request->input('max_people');
        $apartment->price = (int) $request->input('price');
        $apartment->photos = $photos;
        $apartment->owner_id = Auth::id();
        $apartment->country = $address[2];
        $apartment->city = $address[1];
        $apartment->street = $address[0];

        $apartment->save();

        return redirect('/');
    }
}
