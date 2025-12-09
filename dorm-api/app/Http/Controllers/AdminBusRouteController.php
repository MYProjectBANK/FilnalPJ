<?php

namespace App\Http\Controllers;

use App\Models\BusRoute;
use Illuminate\Http\Request;

class AdminBusRouteController extends Controller
{
public function index()
{
    return response()->json([
        'status' => true,
        'data'   => BusRoute::select('id','route_number','route_name')->get(),
    ]);
}


    public function store(Request $request)
    {
        $request->validate([
            'route_number' => 'required|string|max:255',
            'route_name'   => 'required|string|max:255',
        ]);

        $route = BusRoute::create([
            'route_number' => $request->route_number,
            'route_name'   => $request->route_name,
        ]);

        return response()->json($route, 201);
    }

    public function show($id)
    {
        return BusRoute::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $route = BusRoute::findOrFail($id);

        $request->validate([
            'route_number' => 'required|string|max:255',
            'route_name'   => 'required|string|max:255',
        ]);

        $route->update([
            'route_number' => $request->route_number,
            'route_name'   => $request->route_name,
        ]);

        return response()->json($route);
    }

    public function destroy($id)
    {
        $route = BusRoute::findOrFail($id);
        $route->delete();

        return response()->json(['message' => 'Bus route deleted']);
    }
}
