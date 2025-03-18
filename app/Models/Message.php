<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $table = 't_messages';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'company',
        'subject',
        'message',
    ];
}
