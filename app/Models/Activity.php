<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $table = 't_activities';

    protected $fillable = [
        'images',
        'date',
        'title',
        'description',
    ];

    protected $casts = [
        'date' => 'datetime',
    ];
}
