<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dorm;
use App\Models\DormImage;
use Illuminate\Support\Facades\Storage;

class AdminDormController extends Controller
{
    public function index()
    
    {
        return Dorm::with(['categories','amenities','zones','busRoutes','trainLines','images'])->get();
    }


    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|string',
            'email' => 'nullable|email',
        ]);

        // 2) create dorm
        $dorm = Dorm::create($request->except([
            'categories','amenities','zones','bus_routes','train_lines','images'
        ]));

        // 3) sync pivot relations
        if ($request->categories)   $dorm->categories()->sync($request->categories);
        if ($request->amenities)    $dorm->amenities()->sync($request->amenities);
        if ($request->zones)        $dorm->zones()->sync($request->zones);
        if ($request->bus_routes)   $dorm->busRoutes()->sync($request->bus_routes);
        if ($request->train_lines)  $dorm->trainLines()->sync($request->train_lines);

        // 4) upload images (optional)
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {

                $path = $file->store('dorm_images', 'public');

                DormImage::create([
                    'dorm_id' => $dorm->id,
                    'image_path' => $path
                ]);
            }
        }

        return response()->json([
            'message' => 'Dorm created successfully',
            'dorm' => $dorm->load(['categories','amenities','zones','busRoutes','trainLines','images'])
        ]);
    }

    public function show($id)
    {
        $dorm = Dorm::with(['categories','amenities','zones','busRoutes','trainLines','images'])->find($id);

        if (!$dorm) return response()->json(['message' => 'Dorm not found'], 404);

        return $dorm;
    }

    public function update(Request $request, $id)
    {
        $dorm = Dorm::find($id);
        if (!$dorm) return response()->json(['message' => 'Dorm not found'], 404);

        $dorm->update($request->except([
            'categories','amenities','zones','bus_routes','train_lines','images'
        ]));

        // sync relations again
        if ($request->categories)   $dorm->categories()->sync($request->categories);
        if ($request->amenities)    $dorm->amenities()->sync($request->amenities);
        if ($request->zones)        $dorm->zones()->sync($request->zones);
        if ($request->bus_routes)   $dorm->busRoutes()->sync($request->bus_routes);
        if ($request->train_lines)  $dorm->trainLines()->sync($request->train_lines);

        // upload additional images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {

                $path = $file->store('dorm_images', 'public');

                DormImage::create([
                    'dorm_id' => $dorm->id,
                    'image_path' => $path
                ]);
            }
        }

        return response()->json([
            'message' => 'Dorm updated successfully',
            'dorm' => $dorm->load(['categories','amenities','zones','busRoutes','trainLines','images'])
        ]);
    }

    public function destroy($id)
    {
        $dorm = Dorm::find($id);
        if (!$dorm) return response()->json(['message' => 'Dorm not found'], 404);

        // delete images
        foreach ($dorm->images as $img) {
            Storage::disk('public')->delete($img->image_path);
            $img->delete();
        }

        // detach pivot
        $dorm->categories()->detach();
        $dorm->amenities()->detach();
        $dorm->zones()->detach();
        $dorm->busRoutes()->detach();
        $dorm->trainLines()->detach();

        $dorm->delete();

        return response()->json(['message' => 'Dorm deleted']);
    }

    public function deleteImage($id)
{
    $img = DormImage::find($id);
    if (!$img) return response()->json(['message' => 'Image not found'], 404);

    Storage::disk('public')->delete($img->image_path);
    $img->delete();

    return response()->json(['message' => 'Image deleted']);
}

}
