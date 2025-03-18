<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProformaInvoicePaymentProof extends Model

{
    use HasFactory;

    protected $table = 't_proforma_invoice_payment_proofs';

    protected $fillable = [
        'proforma_invoice_id',
        'proof_file_path',
        'status',
        'remarks',
        'payment_type',
        'admin_remarks',
        'is_viewed_admin',
        'is_viewed_distributor',    
    ];

    public function proformaInvoice()
    {
        return $this->belongsTo(ProformaInvoice::class, 'proforma_invoice_id');
    }
}
