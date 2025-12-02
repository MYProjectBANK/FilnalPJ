<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Zone;

class AdminZoneController extends Controller
{
    // GET /api/admin/zones
    public function index()
    {
        return response()->json(Zone::all());
    }

    // POST /api/admin/zones
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
        ]);

        $zone = Zone::create($request->all());

        return response()->json([
            'message' => 'Zone created',
            'zone' => $zone
        ]);
    }

    // GET /api/admin/zones/{id}
    public function show($id)
    {
        return response()->json(Zone::findOrFail($id));
    }

    // PUT /api/admin/zones/{id}
    public function update(Request $request, $id)
    {
        $zone = Zone::findOrFail($id);
        $zone->update($request->all());

        return response()->json([
            'message' => 'Zone updated',
            'zone' => $zone
        ]);
    }

    // DELETE /api/admin/zones/{id}
    public function destroy($id)
    {
        $zone = Zone::findOrFail($id);
        $zone->delete();

        return response()->json(['message' => 'Zone deleted']);
    }
}
