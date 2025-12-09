<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Amenity;

class AdminAmenityController extends Controller
{
    // GET /admin/amenities
    public function index()
    {
        return response()->json([
            'status' => true,
            'data'   => Amenity::all(),
        ]);
    }

    // POST /admin/amenities
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $amenity = Amenity::create($validated);

        return response()->json([
            'status'  => true,
            'message' => 'Amenity created successfully',
            'amenity' => $amenity
        ], 201);
    }

    // GET /admin/amenities/{id}
    public function show($id)
    {
        return response()->json([
            'status' => true,
            'data'   => Amenity::findOrFail($id),
        ]);
    }

    // PUT /admin/amenities/{id}
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $amenity = Amenity::findOrFail($id);
        $amenity->update($validated);

        return response()->json([
            'status'  => true,
            'message' => 'Amenity updated successfully',
            'amenity' => $amenity,
        ]);
    }

    // DELETE /admin/amenities/{id}
    public function destroy($id)
    {
        $amenity = Amenity::findOrFail($id);

        // ❗ ตรวจสอบว่ามี dorm ผูกอยู่ไหม
        if ($amenity->dorms()->count() > 0) {
            return response()->json([
                'status'  => false,
                'message' => 'Cannot delete this amenity because it is assigned to one or more dorms.',
            ], 400);
        }

        $amenity->delete();

        return response()->json([
            'status'  => true,
            'message' => 'Amenity deleted successfully',
        ]);
    }
}
