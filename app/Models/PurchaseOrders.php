<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrders extends Model
{
    use HasFactory;

    protected $table = 't_purchase_orders';

    protected $fillable = [
        'quotation_id',
        'user_id',
        'po_number',
        'status',
        'file_path',
        'is_viewed_distributor',
        'is_viewed_admin',
    ];


    public function quotation()
    {
        return $this->belongsTo(Quotations::class, 'quotation_id');
    }
    

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function proformaInvoices()
    {
        return $this->hasMany(ProformaInvoice::class, 'purchase_order_id');
    }
    

}
