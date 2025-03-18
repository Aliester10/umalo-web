<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 't_product';


    protected $fillable = ['name', 'brand','usage','ekatalog','user_manual','category_id'];

    public function images()
    {
        return $this->hasMany(ProductImage::class, 'product_id');
    }

    public function videos()
    {
        return $this->hasMany(ProductVideo::class, 'product_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'user_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_produk', 'product_id', 'user_id');
    }

    public function documentCertificationsProduct()
    {
        return $this->hasMany(DocumentCertificationsProduct::class); // or hasMany() if multiple
    }

    public function brosur()
    {
        return $this->hasMany(Brosur::class, 'product_id');
    }

    public function userManual()
    {
        return $this->hasMany(UserManual::class, 'product_id');
    }



}
