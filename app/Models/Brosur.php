<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brosur extends Model
{
    use HasFactory;

    protected $table = 't_product_brosur';

    protected $fillable = ['product_id', 'file', 'type'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
