<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyParameter extends Model
{
    use HasFactory;

    protected $table = 't_parameter';

    // Define the fillable fields
    protected $fillable = [
        'email',
        'no_telepon',
        'no_wa',
        'address',
        'maps_url',
        'maps_iframe',
        'visi',
        'misi',
        'logo',
        'logo_support_2',
        'logo_support_3',
        'instagram',
        'linkedin',
        'ekatalog',
        'company_name',
        'short_history',
        'about_gambar',
        'no_acc_bank',
        'bank',

    ];

}
