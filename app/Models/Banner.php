<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;

    protected $table = 't_banner';

    // Define the fillable fields
    protected $fillable = [
        'image_url',
        'title',
        'subtitle',
        'description',
        'button_text',
        'button_url',
    ];
}
