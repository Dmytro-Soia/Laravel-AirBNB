<?php

namespace App\Http\Controllers;

use App\Models\Apartment;
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
}
