<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostCategory extends Model
{
    use HasFactory;

    protected $guarded = [];

    // protected $fillable = ['name', 'slug', 'ordering', 'status'];

    public function posts()
    {
        return $this->belongsToMany(PostList::class, 'categories_products');
    }
}
