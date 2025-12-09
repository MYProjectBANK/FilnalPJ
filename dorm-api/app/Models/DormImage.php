<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DormImage extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'dorm_id',
        'image_path',
    ];

    public function dorm()
    {
        return $this->belongsTo(Dorm::class);
    }
}
