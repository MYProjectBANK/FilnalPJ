<?php

namespace App\Http\Controllers;

use App\Models\Dorm;

class PublicDormController extends Controller
{
    public function recommend()
    {
        return Dorm::inRandomOrder()->take(10)->get();
    }

    public function nearby()
    {
        return Dorm::orderBy('distance', 'asc')->take(10)->get();
    }

    public function byCategory($id)
    {
        return Dorm::where('category_id', $id)->get();
    }
}
