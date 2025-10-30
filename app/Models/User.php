<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Like; 
use App\Models\Comment; 



class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_photo_path',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function profilePhoto()
    {
        // Un utilisateur a une photo de profil
        return $this->hasOne(ProfilePhoto::class);
    }

        /**
     * Relation: Un Utilisateur peut avoir plusieurs Likes.
     */
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    /**
     * Relation: Un Utilisateur peut avoir plusieurs Commentaires.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

}
