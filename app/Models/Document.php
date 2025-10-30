<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
     protected $fillable = [
        'title',
        'description',
        'file_path',
        'biblioCategory_id',
    ];

    // Relation : un document appartient à une catégorie
    public function bibioCategory()
    {
        return $this->belongsTo(BiblioCategory::class);
    }
}
