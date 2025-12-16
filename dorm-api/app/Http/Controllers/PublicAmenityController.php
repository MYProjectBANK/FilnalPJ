<?php

namespace App\Http\Controllers;

use App\Models\Amenity;

class PublicAmenityController extends Controller
{
    public function index()
    {
        return Amenity::all();
    }
}
