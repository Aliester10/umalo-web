<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticketing extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 't_ticketing';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'service_type',
        'submission_description',
        'supporting_document',
        'status',
        'action_start_date',
        'action_close_date',
        'technician',
        'action_description',
        'action_document',
        'is_viewed_admin',
        'is_viewed_member',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'action_start_date' => 'date',
        'action_close_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function requestData()
    {
        return $this->hasMany(TicketingRequestData::class, 'ticketing_id');
    }
    
}
