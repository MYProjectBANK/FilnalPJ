<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory;

    protected $table = 'favorites';

    public $timestamps = false; // table ไม่มี created_at / updated_at

    protected $fillable = [
        'user_id',
        'dorm_id',
    ];

    public function dorm()
    {
        return $this->belongsTo(Dorm::class, 'dorm_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
