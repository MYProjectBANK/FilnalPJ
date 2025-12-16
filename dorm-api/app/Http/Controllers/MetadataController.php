<?php

namespace App\Http\Controllers;

class MetadataController extends Controller
{
    public function faculties()
    {
        return response()->json([
            "คณะวิทยาศาสตร์",
            "คณะวิศวกรรมศาสตร์",
            "คณะบริหารธุรกิจ",
        ]);
    }

    public function yearLevels()
    {
        return response()->json([1, 2, 3, 4]);
    }
}
