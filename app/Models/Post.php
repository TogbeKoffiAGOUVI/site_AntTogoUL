<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
     use HasFactory;
    protected $fillable = [
        'title',
        'slug',
        'category_id',
        'content',
        'excerpt',
        'thumbnail_url',
        'main_media_url',
        'main_media_type',
        'likes_count',
        'views_count',
        'status',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
