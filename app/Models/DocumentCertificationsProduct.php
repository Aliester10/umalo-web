<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentCertificationsProduct extends Model
{
    use HasFactory;

    protected $table = 't_product_document';

    protected $fillable = [
        'product_id',
        'pdf',
    ];

    /**
     * Get the product associated with the document certification.
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'produk_id');
    }
}
