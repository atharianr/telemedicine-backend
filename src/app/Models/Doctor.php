<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Doctor extends Model
{
  use HasFactory;

  protected $table = 'doctors';
  protected $fillable = [
    'name',
    'specialist',
    'education',
    'education_year',
    'phone_number',
    'photo',
  ];

  protected $hidden = [];
}
