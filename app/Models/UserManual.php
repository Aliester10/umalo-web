<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserManual extends Model
{
    use HasFactory;

    protected $table = 't_product_user_manual';

    protected $fillable = [
        'product_id',
        'file',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
