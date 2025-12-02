<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Amenity;

class AdminAmenityController extends Controller
{
    public function index()
    {
        return response()->json(Amenity::all());
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
        ]);

        $amenity = Amenity::create($request->all());

        return response()->json([
            'message' => 'Amenity created',
            'amenity' => $amenity
        ]);
    }

    public function show($id)
    {
        return response()->json(Amenity::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $amenity = Amenity::findOrFail($id);
        $amenity->update($request->all());

        return response()->json([
            'message' => 'Amenity updated',
            'amenity' => $amenity
        ]);
    }

    public function destroy($id)
    {
        $amenity = Amenity::findOrFail($id);
        $amenity->delete();

        return response()->json(['message' => 'Amenity deleted']);
    }
}
