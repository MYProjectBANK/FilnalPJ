<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dorm;

class DormController extends Controller
{

    public function recommend()
{
    return Dorm::inRandomOrder()->take(10)->get();
}

public function byCategory($id)
{
    return Dorm::whereHas('categories', function ($q) use ($id) {
        $q->where('category_id', $id);
    })->get();
}

    // GET /api/dorms
    public function index(Request $request)
    {
        $user_id = $request->user() ? $request->user()->id : null;

        $dorms = Dorm::with(['categories', 'amenities', 'zones', 'images', 'reviews', 'busRoutes', 'trainLines'])
            ->get()
            ->map(function ($dorm) use ($user_id) {
                $dorm->is_favorited = $user_id ? $dorm->favorites()->where('user_id', $user_id)->exists() : false;
                return $dorm;
            });

        return response()->json($dorms);
    }

    // GET /api/dorms/{id}
    public function show(Request $request, $id)
    {
        $user_id = $request->user() ? $request->user()->id : null;

        $dorm = Dorm::with(['categories', 'amenities', 'zones', 'images', 'reviews', 'busRoutes', 'trainLines'])
            ->find($id);

        if (!$dorm) {
            return response()->json(['message' => 'Dorm not found'], 404);
        }

        $dorm->is_favorited = $user_id ? $dorm->favorites()->where('user_id', $user_id)->exists() : false;

        return response()->json($dorm);
    }
}
