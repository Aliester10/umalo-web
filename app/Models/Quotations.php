<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quotations extends Model
{
    use HasFactory;

    protected $table = 't_quotations';

    protected $fillable = [
        'user_id',
        'status',
        'application_number',
        'topic',
        'quotation_number',
        'recipient_company',
        'recipient_contact_person',
        'discount',
        'grand_total',
        'terms_conditions',
        'notes',
        'authorized_person_name',
        'authorized_person_position',
        'authorized_person_signature',
        'subtotal_price',
        'total_after_discount',
        'ppn',
        'pdf_path',
        'is_viewed_distributor',
        'is_viewed_admin',
    ];

    protected $casts = [
        'discount' => 'float',
        'grand_total' => 'float',
        'subtotal_price' => 'float',
        'total_after_discount' => 'float',
        'ppn' => 'float',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function negotiations()
    {
        return $this->hasMany(QuotationNegotiation::class, 'quotation_id', 'id');
    }
    

    public function products()
    {
        return $this->hasMany(QuotationProduct::class, 'quotation_id', 'id');
    }

    public function purchaseOrders()
    {
        return $this->hasMany(PurchaseOrders::class, 'quotation_id', 'id');
    }
    

    public function proformaInvoices()
    {
        return $this->hasMany(ProformaInvoice::class, 'quotation_id', 'id');
    }
    
    
}
