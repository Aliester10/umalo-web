<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProductDocumentationFile extends Model
{
    use HasFactory;

    protected $table = 't_user_product_documentation_file';

    protected $fillable = ['documentation_id', 'file'];

    public function documentation()
    {
        return $this->belongsTo(UserProductDocumentation::class, 'documentation_id');
    }
}
