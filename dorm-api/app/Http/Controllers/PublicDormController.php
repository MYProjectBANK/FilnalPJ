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
        $dorm = Dorm::with(['images', 'categories', 'zones', 'amenities', 'busRoutes', 'trainLines'])->findOrFail($id);
        $dorm->price_range = $this->priceRange($dorm);
        return $dorm;
    }

    /**
     * ⭐ NEW: ระบบฟิลเตอร์เต็มรูปแบบ
     */
public function filter(Request $req) {
    $perPage = (int) ($req->per_page ?? 12);
    $perPage = max(1, min($perPage, 48));


    $query = Dorm::query()->with(['images','categories','zones','amenities','busRoutes']);

    // Search: ชื่อ + จังหวัด/อำเภอ/ตำบล (แนะนำ)
    if ($req->search) {
        $s = $req->search;
        $query->where(function ($q) use ($s) {
            $q->where('name', 'LIKE', "%{$s}%")
              ->orWhere('province', 'LIKE', "%{$s}%")
              ->orWhere('district', 'LIKE', "%{$s}%")
              ->orWhere('subdistrict', 'LIKE', "%{$s}%");
        });
    }

    if ($req->category) {
        $query->whereHas('categories', fn($q) => $q->where('category_id', $req->category));
    }

    if (!empty($req->amenity)) {
        $ids = is_array($req->amenity) ? $req->amenity : [$req->amenity];
        $query->whereHas('amenities', fn($q) => $q->whereIn('amenity_id', $ids));
    }

    if ($req->bus) {
        $query->whereHas('busRoutes', fn($q) => $q->where('bus_route_id', $req->bus));
    }

    if ($req->filled('price_min') && $req->filled('price_max')) {
    $query->whereBetween('price_min', [(int)$req->price_min, (int)$req->price_max]);
}


    // ✅ paginate
    $paginator = $query->paginate($perPage)->appends($req->query());


    $paginator->getCollection()->transform(function ($d) {
        $d->price_range = $this->priceRange($d);
        return $d;
    });

    return response()->json($paginator);
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
