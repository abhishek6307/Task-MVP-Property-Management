<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;


class HomeController extends Controller
{
    public function index(Request $request)
    {
        $query = Property::query();

        if ($search = $request->input('search')) {
            $query->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
        }

        if ($type = $request->input('type')) {
            $query->where('type', $type);
        }

        if ($minPrice = $request->input('min_price')) {
            $query->where('price', '>=', $minPrice);
        }

        if ($maxPrice = $request->input('max_price')) {
            $query->where('price', '<=', $maxPrice);
        }

        if ($bedrooms = $request->input('bedrooms')) {
            $query->where('bedrooms', $bedrooms);
        }

        if ($bathrooms = $request->input('bathrooms')) {
            $query->where('bathrooms', $bathrooms);
        }

        if ($sortBy = $request->input('sort_by')) {
            $sortDirection = $request->input('sort_direction', 'asc');
            $query->orderBy($sortBy, $sortDirection);
        }
        $favoriteCount = auth()->user()->favoriteCount();
        $properties = $query->paginate(9);
        return view('home', compact('properties', 'favoriteCount'));
    }
}
