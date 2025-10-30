<?php

namespace App\Models;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;


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
        return $this->belongsTo(CategoryBlog::class);
    }

    // Accessors for thumbnail_url and main_media_url are defined above.

    public function comments()
    {
       
        return $this->hasMany(Comment::class);
        
    }
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    // --- ACCESSORS ---
    public function getThumbnailUrlAttribute($value)
    {
        return $value ? Storage::url($value) : null;
    }

    public function getMainMediaUrlAttribute($value)
    {
        return $value ? Storage::url($value) : null;
    }
}
