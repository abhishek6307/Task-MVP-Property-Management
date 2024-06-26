<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Property;

class DashboardController extends Controller
{
    public function index()
    {
        $properties = Property::all();

        return view('properties.index', compact('properties'));
    }
}
