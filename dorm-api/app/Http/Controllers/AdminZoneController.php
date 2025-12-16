<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Zone;

class AdminZoneController extends Controller
{
    // GET /admin/zones
public function index()
{
    return response()->json([
        'status' => true,
        'data' => Zone::all()
    ]);
}



    // POST /admin/zones
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $zone = Zone::create($validated);

        return response()->json([
            'status' => true,
            'message' => 'Zone created successfully',
            'data' => $zone
        ], 201);
    }

    // GET /admin/zones/{id}
    public function show($id)
    {
        return response()->json([
            'status' => true,
            'data'   => Zone::findOrFail($id)
        ]);
    }

    // PUT /admin/zones/{id}
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $zone = Zone::findOrFail($id);
        $zone->update($validated);

        return response()->json([
            'status' => true,
            'message' => 'Zone updated successfully',
            'data' => $zone
        ]);
    }

    // DELETE /admin/zones/{id}
    public function destroy($id)
    {
        $zone = Zone::findOrFail($id);

        $zone->delete();

        return response()->json([
            'status' => true,
            'message' => 'Zone deleted successfully'
        ]);
    }
}
