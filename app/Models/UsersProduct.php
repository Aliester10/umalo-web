<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class UsersProduct extends Pivot
{
    protected $table = 't_users_product';

    protected $fillable = ['user_id', 'product_id', 'purchase_date','quantity'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function documentations()
    {
        return $this->hasMany(UserProductDocumentation::class, 'users_product_id');
    }


}
