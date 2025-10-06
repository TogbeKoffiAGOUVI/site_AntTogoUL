<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    // protected $fillable = [
    //     'id',
    //     'firstname',
    //     'lastname',
    //     'telephone',
    //     'email',
    //     'field_of_student',
    //     'speciality',
    //     'graduate',
    //     'promotion',
    //     'biography',
    //     'social_media',
    //     'photo',
    // ];

    protected $fillable = [
        'id',
        'photo',
        'firstname',
        'lastname',
        'telephone',
        'email',
        'field_of_student',
        'speciality',
        'graduate',
        'promotion',
        'social_media',
        'biography'
    ];
}
