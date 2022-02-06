<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductList extends Model
{
    use HasFactory;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'product_lists';

    protected $guarded = [];

    // protected $fillable = ['code', 'name', 'slug', 'description', 'price', 'sale', 'status', 'special', 'label', 'video'];

    public function categories()
    {
        return $this->belongsToMany(ProductCategory::class, 'categories_products');
    }

    public function images()
    {
        return $this->belongsToMany(ProductImage::class, 'images_products')->orderBy('ordering', 'asc');
    }
}
