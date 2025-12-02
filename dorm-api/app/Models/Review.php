<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $table = 'reviews';

    protected $fillable = [
        'user_id',
        'dorm_id',
        'comment',
        'status',
    ];

    public $timestamps = true; 

    public function dorm()
    {
        return $this->belongsTo(Dorm::class, 'dorm_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
