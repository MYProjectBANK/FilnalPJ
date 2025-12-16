<?php

namespace App\Http\Controllers;

use App\Models\BusRoute;

class PublicBusRouteController extends Controller
{
    public function index()
    {
        return BusRoute::all();
    }
}
