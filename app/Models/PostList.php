<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostList extends Model
{
    use HasFactory;

    protected $guarded = [];

    // protected $fillable = [
    //     'id', 'title', 'slug', 'description', 'content', 'status', 'special', 'picture', 'created_by', 'updated_by',
    // ];

    public function categories()
    {
        return $this->belongsToMany(PostCategory::class, 'categories_products');
    }
}
