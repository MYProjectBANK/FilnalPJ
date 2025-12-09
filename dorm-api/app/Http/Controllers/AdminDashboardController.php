<?php

namespace App\Http\Controllers;

use App\Models\Dorm;
use App\Models\User;
use App\Models\Category;
use App\Models\Amenity;
use App\Models\Zone;
use App\Models\BusRoute;
use App\Models\TrainLine;
use App\Models\Review;

class AdminDashboardController extends Controller
{
    public function stats()
    {
        return response()->json([
            'dorms'           => Dorm::count(),
            'users'           => User::count(),
            'reviews_pending' => Review::where('status', 'pending')->count(),
            'categories'      => Category::count(),
            'amenities'       => Amenity::count(),
            'zones'           => Zone::count(),
            'bus_routes'      => BusRoute::count(),
            'train_lines'     => TrainLine::count(),
        ]);
    }
}
