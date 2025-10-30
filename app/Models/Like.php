<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;

    // Champs qui peuvent être assignés en masse
    protected $fillable = [
        'user_id',
        'post_id',
    ];

    /**
     * Relation: Le Like appartient à un Utilisateur.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relation: Le Like appartient à un Article.
     */
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}

