<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVideo extends Model
{
    use HasFactory;

    protected $table = 't_product_video';

    protected $fillable = ['product_id', 'video',];

    public function produk()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
