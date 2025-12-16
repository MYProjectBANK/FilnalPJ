<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dorm;

class PublicDormController extends Controller
{
    public function recommend()
    {
        return Dorm::with(['images', 'categories', 'zones'])
            ->inRandomOrder()
            ->take(10)
            ->get()
            ->map(function ($d) {
                $d->price_range = $this->priceRange($d);
                return $d;
            });
    }

    public function nearby()
    {
        return Dorm::with(['images', 'categories', 'zones'])
            ->orderBy('id', 'desc')
            ->take(10)
            ->get()
            ->map(function ($d) {
                $d->price_range = $this->priceRange($d);
                return $d;
            });
    }

    public function byCategory($id)
    {
        return Dorm::with(['images', 'categories', 'zones'])
            ->whereHas('categories', function ($q) use ($id) {
                $q->where('category_id', $id);
            })
            ->get()
            ->map(function ($d) {
                $d->price_range = $this->priceRange($d);
                return $d;
            });
    }

    public function index()
    {
        return Dorm::with(['images', 'categories', 'zones'])
            ->get()
            ->map(function ($d) {
                $d->price_range = $this->priceRange($d);
                return $d;
            });
    }

    public function show($id)
    {
        $dorm = Dorm::with(['images', 'categories', 'zones'])->findOrFail($id);
        $dorm->price_range = $this->priceRange($dorm);
        return $dorm;
    }

    /**
     * ⭐ NEW: ระบบฟิลเตอร์เต็มรูปแบบ
     */
    public function filter(Request $req)
    {
        $query = Dorm::query()->with(['images', 'categories', 'zones', 'amenities', 'busRoutes']);

        // Search by name
        if ($req->search) {
            $query->where('name', 'LIKE', "%{$req->search}%");
        }

        // Category filter
        if ($req->category) {
            $query->whereHas('categories', fn($q) =>
                $q->where('category_id', $req->category)
            );
        }

        // Amenity filter
        if ($req->amenity) {
            $query->whereHas('amenities', fn($q) =>
                $q->where('amenity_id', $req->amenity)
            );
        }

        // Bus Route filter
        if ($req->bus) {
            $query->whereHas('busRoutes', fn($q) =>
                $q->where('bus_route_id', $req->bus)
            );
        }

        // Price range filter
        if ($req->price_min && $req->price_max) {
            $query->whereBetween('price_min', [
                $req->price_min,
                $req->price_max
            ]);
        }

        // return results with price_range field added
        return $query->get()->map(function ($d) {
            $d->price_range = $this->priceRange($d);
            return $d;
        });
    }

    private function priceRange($dorm)
    {
        if (!is_null($dorm->price_min) && !is_null($dorm->price_max)) {
            return "฿{$dorm->price_min} - ฿{$dorm->price_max}";
        }

        if (!is_null($dorm->price_min)) {
            return "฿{$dorm->price_min}";
        }

        return "ไม่ระบุราคา";
    }
}
