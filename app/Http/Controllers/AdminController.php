<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;

class AdminController extends Controller
{
    public function index()
    {
        Gate::authorize('user_is_admin');
        $users = User::orderBy('admin', 'desc')->get();
        return view('admin', ['users' => $users]);
    }

    public function changeStatus(User $user)
    {
        Gate::authorize('user_is_admin');
        if ($user->id === auth()->id()) {
            return redirect('/adminpanel')->withErrors('You cannot change the status of yourself.');
        }
        $user->update([
            'admin' => !$user->admin
        ]);
        return redirect()->back();
    }
}
