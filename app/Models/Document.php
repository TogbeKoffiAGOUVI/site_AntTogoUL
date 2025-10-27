<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'file_path',
        'category_id',
    ];

    // Relation : un document appartient à une catégorie
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
