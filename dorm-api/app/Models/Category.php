<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';

    // อนุญาตให้บันทึก field name
    protected $fillable = ['name'];

    // ความสัมพันธ์กับ Dorm
public function dorms()
{
    return $this->belongsToMany(Dorm::class, 'dorm_categories', 'category_id', 'dorm_id');
}
}
