<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meta extends Model
{
    use HasFactory; 

    protected $table = 't_meta';


    protected $fillable = [
        'title', 'slug', 'start_date', 'end_date', 'content', 'type'
    ];
}
