<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainLine extends Model
{
    use HasFactory;

    protected $table = 'train_lines';

    public $timestamps = false;

    protected $fillable = [
        'line_name',
        'station_name',
    ];
}
