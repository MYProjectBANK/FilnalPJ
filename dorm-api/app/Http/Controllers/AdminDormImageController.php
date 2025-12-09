<?php

namespace App\Http\Controllers;

use App\Models\DormImage;
use Illuminate\Support\Facades\Storage;

class AdminDormImageController extends Controller
{
    public function destroy($id)
    {
        $image = DormImage::find($id);

        if (!$image) {
            return response()->json(['message' => 'Image not found'], 404);
        }

        // ลบไฟล์ใน storage
        Storage::disk('public')->delete($image->image_path);

        // ลบ row จาก database
        $image->delete();

        return response()->json(['message' => 'Image deleted']);
    }
}
