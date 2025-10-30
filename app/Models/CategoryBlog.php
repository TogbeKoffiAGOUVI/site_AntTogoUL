<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryBlog extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description'
    ];
    
    public function posts()
    {
        return $this->hasMany(Post::class, 'category_id');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
