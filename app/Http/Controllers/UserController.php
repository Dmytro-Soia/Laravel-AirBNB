<?php

namespace App\Http\Controllers;

use App\Models\Apartment;
use App\Models\Booking;
use App\Models\Image;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function authenticate(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'max:255'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'confirmed'],
        ]);

        User::create($request->all());

        return redirect('login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/');
        }
        return back()->withErrors([
            'email' => 'The provided credential do not match our records:(',
        ])->onlyInput('email');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

    public function userprofile(User $user)
    {
        $apartmnets = Apartment::where('owner_id', $user->id)->with('images')->orderBy('created_at', 'desc')->get();
        $bookings = Booking::where('tenant_id', $user->id)->orderBy('created_at', 'desc')->get();
        return view('userprofile', ['user' => $user, 'apartments' => $apartmnets, 'bookings' => $bookings]);
    }

    public function edit_user_profile_index(User $user)
    {
        Gate::authorize('same_user', $user->id);

        return view('edit_profile', ['user' => $user]);
    }

    public function edited(Request $request, User $user)
    {
        Gate::authorize('same_user', $user->id);
        $request->validate([
            'name' => ['required', 'max:255'],
            'email' => ['required', 'email'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg'],
        ]);
        $user->name = $request->input('name');
        $user->email = $request->input('email');

        if ($request->hasFile('prof_pic')) {
            if (isset($user->profile_img)) {
                Storage::disk('public')->delete('images/' . $user->profile_img);
                $user->profile_img = null;
                User::saveImg($request->file('prof_pic'), $user);
            } else {
                User::saveImg($request->file('prof_pic'), $user);
            }
        }
        $user->save();

        return redirect(route('userprofile.user', ['user' => $user]));
    }

    public function deleteProfile(User $user)
    {
        $user = User::with(['apartments.images', 'bookings.apartment'])->find($user->id);
        foreach ($user->apartments as $apartment) {
            foreach ($apartment->images as $image) {
                Storage::disk('public')->delete('images/' . $image->path);
            }
            Image::where('apartment_id', $apartment->id)->delete();
            Booking::where('apartment_id', $apartment->id)->delete();
        }
        Booking::where('tenant_id', $user->id)->delete();
        Apartment::where('owner_id', $user->id)->delete();
        User::where('id', $user->id)->delete();

        return view('login');
    }
}
