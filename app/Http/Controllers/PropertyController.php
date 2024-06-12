<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\Inquiry;
use App\Models\Viewing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PropertyController extends Controller
{
    public function index()
    {
        $properties = Cache::remember('properties', now()->addMinutes(1), function () {
            return Property::all();
        });

        return view('properties.index', compact('properties'));
    }

    public function create()
    {
        return view('properties.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'address' => 'required|string',
            'price' => 'required|numeric',
            'bedrooms' => 'required|integer',
            'bathrooms' => 'required|integer',
            'type' => 'required|string',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
        ]);

        Property::create([
            'title' => $request->title,
            'description' => $request->description,
            'address' => $request->address,
            'price' => $request->price,
            'bedrooms' => $request->bedrooms,
            'bathrooms' => $request->bathrooms,
            'type' => $request->type,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('properties.index')->with('success', 'Property created successfully.');
    }

    public function show($id)
    {
        $property = Cache::remember('property_' . $id, now()->addMinutes(5), function () use ($id) {
            return Property::findOrFail($id);
        });

        $property->increment('views');

        return view('properties.show', compact('property'));
    }

    public function toggleLike(Request $request, $id)
    {
        if (auth()->check()) {
            $property = Property::findOrFail($id);
            $user = auth()->user();

            if ($property->isLikedBy($user)) {
                // User has already liked the property, so unlike it
                $property->likedUsers()->detach($user->id);
                $liked = false;
            } else {
                // User hasn't liked the property yet, so like it
                $property->likedUsers()->attach($user->id);
                $liked = true;
            }

            // Return the updated like status and count
            return response()->json(['liked' => $liked, 'likes' => $property->likedUsers()->count()]);
        } else {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }
    }

    public function share(Request $request, $id)
    {
        $property = Property::findOrFail($id);
        $property->incrementShares();

        // Return the updated share count
        return response()->json(['shares' => $property->shares]);
    }

     public function edit(Property $property)
    {
        return view('properties.edit', compact('property'));
    }

    public function update(Request $request, Property $property)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'address' => 'required|string',
            'price' => 'required|numeric',
            'bedrooms' => 'required|integer',
            'bathrooms' => 'required|integer',
            'type' => 'required|string',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
        ]);

        $property->update([
            'title' => $request->title,
            'description' => $request->description,
            'address' => $request->address,
            'price' => $request->price,
            'bedrooms' => $request->bedrooms,
            'bathrooms' => $request->bathrooms,
            'type' => $request->type,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ]);

        return redirect()->route('properties.index')->with('success', 'Property updated successfully.');
    }

    public function destroy(Property $property)
    {
        $property->delete();
        return redirect()->route('properties.index')->with('success', 'Property deleted successfully.');
    }

    public function submitInquiry(Request $request, $id)
    {
        if (auth()->check()) {
            $request->validate([
                'message' => 'required|string|max:1000',
            ]);

            Inquiry::create([
                'user_id' => auth()->id(),
                'property_id' => $id,
                'message' => $request->message,
            ]);

            return back()->with('success', 'Inquiry submitted successfully.');
        } else {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }
    }

    public function scheduleViewing(Request $request, $id)
    {
        if (auth()->check()) {
            $request->validate([
                'viewing_date' => 'required|date|after:today',
            ]);

            Viewing::create([
                'user_id' => auth()->id(),
                'property_id' => $id,
                'viewing_date' => $request->viewing_date,
            ]);

            return back()->with('success', 'Viewing scheduled successfully.');
        } else {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }
    }
    public function map()
    {
        $properties = Cache::remember('properties_map', now()->addMinutes(5), function () {
            return Property::whereNotNull('latitude')->whereNotNull('longitude')->get();
        });

        return view('properties.map', compact('properties'));
    }
}
