<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dorm extends Model
{
    use HasFactory;

    protected $table = 'dorms';

protected $fillable = [
    'name',
    'description',
    'province',
    'district',
    'subdistrict',
    'street',
    'zipcode',
    'phone',
    'email',
    'facebook',
    'line_id',
    'price_min',
    'price_max',
    'deposit_price',
    'electricity_rate',
    'water_rate',
    'internet_fee',
    'latitude',
    'longitude',
];


    // Relation: Categories
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'dorm_categories', 'dorm_id', 'category_id')
                    ->as('pivotCategory'); // ตั้ง alias เพื่อป้องกัน SQL alias ซ้ำ
    }

    // Relation: Amenities
    public function amenities()
    {
        return $this->belongsToMany(Amenity::class, 'dorm_amenities', 'dorm_id', 'amenity_id')
                    ->as('pivotAmenity');
    }

    // Relation: Zones
    public function zones()
    {
        return $this->belongsToMany(Zone::class, 'dorm_zones', 'dorm_id', 'zone_id')
                    ->as('pivotZone');
    }

public function busRoutes()
{
    return $this->belongsToMany(BusRoute::class, 'dorm_bus_routes', 'dorm_id', 'bus_route_id')
                ->as('pivotBusRoute'); 
}


public function trainLines()
{
    return $this->belongsToMany(TrainLine::class, 'dorm_train_lines', 'dorm_id', 'train_line_id')
                ->as('pivotTrainLine');
}


    // Relation: Images
    public function images()
    {
        return $this->hasMany(DormImage::class, 'dorm_id');
    }

    // Relation: Reviews
    public function reviews()
    {
        return $this->hasMany(Review::class, 'dorm_id');
    }

    // Relation: Favorites
    public function favorites()
    {
        return $this->hasMany(Favorite::class, 'dorm_id');
    }
}
