<?php

namespace App\Http\Controllers;

use App\Models\Apartment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomePageController extends Controller
{
    public function index()
    {
        $apartments = Apartment::with('images')->get();

        return view('home', ['apartments' => $apartments]);
    }
}
