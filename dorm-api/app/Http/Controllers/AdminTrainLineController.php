<?php

namespace App\Http\Controllers;

use App\Models\TrainLine;
use Illuminate\Http\Request;

class AdminTrainLineController extends Controller
{
public function index()
{
    return response()->json([
        'status' => true,
        'data'   => TrainLine::select('id','line_name','station_name')->get(),
    ]);
}


    public function store(Request $request)
    {
        $request->validate([
            'line_name'     => 'required|string|max:255',
            'station_name'  => 'required|string|max:255',
        ]);

        $line = TrainLine::create([
            'line_name'     => $request->line_name,
            'station_name'  => $request->station_name,
        ]);

        return response()->json($line, 201);
    }

    public function show($id)
    {
        return TrainLine::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $line = TrainLine::findOrFail($id);

        $request->validate([
            'line_name'     => 'required|string|max:255',
            'station_name'  => 'required|string|max:255',
        ]);

        $line->update([
            'line_name'     => $request->line_name,
            'station_name'  => $request->station_name,
        ]);

        return response()->json($line);
    }

    public function destroy($id)
    {
        $line = TrainLine::findOrFail($id);
        $line->delete();

        return response()->json(['message' => 'Train line deleted']);
    }
}
