<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuotationNegotiation extends Model
{
    use HasFactory;

    protected $table = 't_quotations_negotiations';

    protected $fillable = [
        'quotation_id',
        'status',
        'distributor_notes',
        'admin_notes',
        'is_viewed_admin',
        'is_viewed_distributor',
    ];

    public function quotation()
    {
        return $this->belongsTo(Quotations::class);
    }

}
