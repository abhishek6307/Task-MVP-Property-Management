<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Property;

class FavoriteController extends Controller
{
    public function index()
    {
        if (auth()->check()) {
            $favoriteProperties = auth()->user()->favoriteProperties()->paginate(10); // Paginate for better UI handling
            $favoriteCount = auth()->user()->favoriteCount();
            return view('favorites.index', compact('favoriteProperties','favoriteCount'));
        } else {
            return redirect()->route('login')->with('error', 'You must be logged in to view favorites.');
        }
    }

    public function toggleFavorite($id)
    {
        $property = Property::findOrFail($id);

        if (auth()->check()) {
            $user = auth()->user();
            $isFavorited = $user->toggleFavorite($property);
            $favoriteCount = auth()->user()->favoriteCount();
            return response()->json(['favorite' => $isFavorited,'favoriteCount' => $favoriteCount]);
        } else {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }
    }
}
