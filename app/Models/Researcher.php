<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Researcher extends Model
{
    protected $fillable = [
        'id',
        'photo',
        'firstname',
        'lastname',
        'graduate',
        'searcherprofil',
        'telephone',
        'email',
    ];
}
