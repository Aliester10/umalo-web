<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProformaInvoice extends Model
{
    use HasFactory;

    // Table associated with the model
    protected $table = 't_proforma_invoice';

    // Mass assignable columns
    protected $fillable = [
        'purchase_order_id',
        'pi_number',
        'pi_date',
        'subtotal',
        'ppn',
        'grand_total_include_ppn',
        'dp',
        'grand_total_after_dp', // Newly added column
        'file_path',
        'remarks',
        'status', // Newly added column
        'quotation_id',
    ];

    /**
     * Relation to the Purchase Order.
     */
    public function purchaseOrder()
    {
        return $this->belongsTo(PurchaseOrders::class, 'purchase_order_id');
    }

    public function proformaInvoice()
    {
        return $this->belongsTo(ProformaInvoice::class, 'proforma_invoice_id');
    }

    public function paymentProofs()
    {
        return $this->hasMany(ProformaInvoicePaymentProof::class, 'proforma_invoice_id');
    }

    /**
     * Relation to the Quotation.
     */
    public function quotation()
    {
        return $this->belongsTo(Quotations::class, 'quotation_id');
    }

    /**
     * Accessor for calculating the remaining balance after payments.
     * 
     * @return float
     */
    public function getRemainingPaymentAttribute()
    {
        $dpPaid = $this->paymentProofs
            ->where('payment_type', 'dp')
            ->where('status', 'accepted')
            ->sum('amount');

        return max($this->grand_total_include_ppn - $dpPaid, 0);
    }


    /**
     * Accessor for checking if the invoice is fully paid.
     * 
     * @return bool
     */
    public function getIsPaidAttribute()
    {
        return $this->status === 'paid';
    }

    /**
     * Mutator to automatically update the `grand_total_after_dp` when `dp` is set.
     * 
     * @param float $value
     */
    public function setDpAttribute($value)
    {
        $this->attributes['dp'] = $value;
        $this->attributes['grand_total_after_dp'] = $this->grand_total_include_ppn - $value;
    }
}
