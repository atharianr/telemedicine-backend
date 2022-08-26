<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Experiences extends Model
{
    use HasFactory;

    protected $table = 'experiences';
    protected $fillable = [
        'location',
        'first_year',
        'last_year',
    ];

    protected $hidden = [];
}