<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dorm;

class DormController extends Controller
{
    // GET /api/dorms
    public function index(Request $request)
    {
        $user_id = $request->user() ? $request->user()->id : null;

        $dorms = Dorm::with(['categories', 'amenities', 'zones', 'images', 'reviews', 'busRoutes', 'trainLines'])
            ->get()
            ->map(function ($dorm) use ($user_id) {
                $dorm->is_favorited = $user_id
                    ? $dorm->favorites()->where('user_id', $user_id)->exists()
                    : false;

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

        $dorm->is_favorited = $user_id
            ? $dorm->favorites()->where('user_id', $user_id)->exists()
            : false;

        return response()->json($dorm);
    }

    
public function suggest(Request $request)
{
    $q = trim((string) $request->query('q', ''));

    if ($q === '' || mb_strlen($q) < 1) {
        return response()->json([]);
    }

    $items = Dorm::query()
        ->select('id', 'name', 'province', 'district', 'subdistrict', 'price_min')
        ->where(function ($query) use ($q) {
            $query->where('name', 'like', "%{$q}%")
                  ->orWhere('province', 'like', "%{$q}%")
                  ->orWhere('district', 'like', "%{$q}%")
                  ->orWhere('subdistrict', 'like', "%{$q}%");
        })
        ->limit(8)
        ->get();

    return response()->json($items);
}
}
