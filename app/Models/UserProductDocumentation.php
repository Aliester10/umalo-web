<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProductDocumentation extends Model
{
    use HasFactory;

    protected $table = 't_user_product_documentation';

    protected $fillable = ['users_product_id', 'status'];

    public function userProduct()
    {
        return $this->belongsTo(UsersProduct::class, 'users_product_id');
    }

    public function files()
    {
        return $this->hasMany(UserProductDocumentationFile::class, 'documentation_id');
    }
}
