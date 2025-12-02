<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens; // สำหรับ token API

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    // ชื่อตาราง
    protected $table = 'users';

    // ฟิลด์ที่อนุญาตให้ mass assignment
    protected $fillable = [
        'fullname',
        'email',
        'password',
        'phone',
        'year_level',
        'faculty',
        'role',
    ];

    // ซ่อนฟิลด์สำคัญ เช่น password
    protected $hidden = [
        'password',
    ];

    // ความสัมพันธ์กับตาราง reviews
    public function reviews()
    {
        return $this->hasMany(Review::class, 'user_id');
    }

    // ความสัมพันธ์กับตาราง favorites
    public function favorites()
    {
        return $this->hasMany(Favorite::class, 'user_id');
    }
}
