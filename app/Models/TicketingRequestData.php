<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketingRequestData extends Model
{
    use HasFactory;
    protected $table = 't_ticketing_request_data';
    protected $fillable = [
        'ticketing_id',
        'document_name',
        'document_path',
        'is_viewed_member',
    ];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function ticketing()
    {
        return $this->belongsTo(Ticketing::class, 'ticketing_id');
    }
}
