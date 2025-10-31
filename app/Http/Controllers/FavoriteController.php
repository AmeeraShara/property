<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FavoriteController extends Controller
{
    public function toggleFavorite(Request $request)
    {
        $request->validate([
            'property_id' => 'required|exists:posts,id'
        ]);

        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Please login to add favorites'
            ], 401);
        }

        $userId = Auth::id();
        $propertyId = $request->property_id;

        
        $existingFavorite = DB::table('user_favorites')
            ->where('user_id', $userId)
            ->where('property_id', $propertyId)
            ->first();

        if ($existingFavorite) {
           
            DB::table('user_favorites')
                ->where('user_id', $userId)
                ->where('property_id', $propertyId)
                ->delete();
            
            $isFavorited = false;
            $message = 'Removed from favorites';
        } else {
          
            DB::table('user_favorites')->insert([
                'user_id' => $userId,
                'property_id' => $propertyId,
                'created_at' => now(),
                'updated_at' => now()
            ]);
            
            $isFavorited = true;
            $message = 'Added to favorites';
        }

        return response()->json([
            'success' => true,
            'is_favorited' => $isFavorited,
            'message' => $message
        ]);
    }


    public function getFavorites()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $favorites = Auth::user()->favoriteProperties()->paginate(12);
        
        return view('favorites.index', compact('favorites'));
    }

   
    
    public function getFavoriteCount($propertyId)
    {
        $count = DB::table('user_favorites')
            ->where('property_id', $propertyId)
            ->count();

        return response()->json([
            'success' => true,
            'count' => $count
]);
}
}