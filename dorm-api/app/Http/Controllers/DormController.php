<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dorm;

class DormController extends Controller
{
    // GET /api/dorms
    public function index()
    {
        $dorms = Dorm::with(['categories', 'amenities', 'zones', 'images', 'reviews', 'busRoutes', 'trainLines'])->get();

        return response()->json($dorms);
    }

    // GET /api/dorms/{id}
    public function show($id)
    {
        $dorm = Dorm::with(['categories', 'amenities', 'zones', 'images', 'reviews', 'busRoutes', 'trainLines'])
                ->find($id);

        if(!$dorm){
            return response()->json(['message' => 'Dorm not found'], 404);
        }

        return response()->json($dorm);
    }
}
