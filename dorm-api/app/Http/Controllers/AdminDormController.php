<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dorm;

class AdminDormController extends Controller
{
    public function index()
    {
        $dorms = Dorm::all();
        return response()->json($dorms);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
            'province' => 'nullable|string',
            'district' => 'nullable|string',
            'subdistrict' => 'nullable|string',
            'street' => 'nullable|string',
            'zipcode' => 'nullable|string',
            'phone' => 'nullable|string',
            'email' => 'nullable|email',
            'facebook' => 'nullable|string',
            'line_id' => 'nullable|string',
            'price_min' => 'nullable|numeric',
            'price_max' => 'nullable|numeric',
            'deposit_price' => 'nullable|numeric',
            'electricity_rate' => 'nullable|numeric',
            'water_rate' => 'nullable|numeric',
            'internet_fee' => 'nullable|numeric',
            'latitude' => 'nullable|string',
            'longitude' => 'nullable|string',
        ]);

        $dorm = Dorm::create($request->all());

        return response()->json([
            'message' => 'Dorm created',
            'dorm' => $dorm
        ]);
    }

    public function show($id)
    {
        $dorm = Dorm::find($id);
        if (!$dorm) return response()->json(['message' => 'Dorm not found'], 404);

        return response()->json($dorm);
    }

    public function update(Request $request, $id)
    {
        $dorm = Dorm::find($id);
        if (!$dorm) return response()->json(['message' => 'Dorm not found'], 404);

        $dorm->update($request->all());

        return response()->json([
            'message' => 'Dorm updated',
            'dorm' => $dorm
        ]);
    }

    public function destroy($id)
    {
        $dorm = Dorm::find($id);
        if (!$dorm) return response()->json(['message' => 'Dorm not found'], 404);

        $dorm->delete();

        return response()->json(['message' => 'Dorm deleted']);
    }
}
