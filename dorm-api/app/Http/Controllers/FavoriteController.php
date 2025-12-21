<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Favorite;
use App\Models\Dorm;

class FavoriteController extends Controller
{
    // POST /api/favorites/add/{dorm_id}
    public function add(Request $request, $dorm_id)
    {
        $user = $request->user();

        $dorm = Dorm::find($dorm_id);
        if (!$dorm) {
            return response()->json(['message' => 'Dorm not found'], 404);
        }

        $exists = Favorite::where('user_id', $user->id)
            ->where('dorm_id', $dorm_id)
            ->exists();

        if ($exists) {
            return response()->json(['message' => 'Already favorited'], 400);
        }

        $favorite = Favorite::create([
            'user_id' => $user->id,
            'dorm_id' => $dorm_id,
        ]);

        return response()->json([
            'message' => 'Added to favorites',
            'favorite' => $favorite
        ]);
    }

    // DELETE /api/favorites/remove/{dorm_id}
    public function remove(Request $request, $dorm_id)
    {
        $user = $request->user();

        $favorite = Favorite::where('user_id', $user->id)
            ->where('dorm_id', $dorm_id)
            ->first();

        if (!$favorite) {
            return response()->json(['message' => 'Favorite not found'], 404);
        }

        $favorite->delete();

        return response()->json(['message' => 'Removed from favorites']);
    }

    // GET /api/favorites
// GET /api/favorites
public function list(Request $request)
{
    $user = $request->user();

    $favorites = Favorite::where('user_id', $user->id)
        ->with([
            'dorm.images',
            'dorm.categories',
            'dorm.zones',
            'dorm.amenities',
            'dorm.busRoutes',
            'dorm.trainLines',
        ])
        ->get();

    return response()->json($favorites);
}

}
