<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuotationProduct extends Model
{
    use HasFactory;

    protected $table = 't_quotations_product';

    protected $fillable = [
        'quotation_id',
        'product_id',
        'quantity',
        'unit_price',
        'total_price',
    ];

    public function quotation()
    {
        return $this->belongsTo(Quotations::class, 'quotation_id', 'id');
    }
    

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
    
    
}
