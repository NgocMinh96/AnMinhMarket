<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    use HasFactory;

    protected $guarded = [];

    // protected $fillable = ['image', 'ordering'];

    public function products()
    {
        return $this->belongsToMany(ProductList::class, 'images_products');
    }
}
