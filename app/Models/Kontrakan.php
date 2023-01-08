<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kontrakan extends Model
{
    use HasFactory;

    protected $table = 'kontrakans';

    protected $fillable = ['UserID',
    'Address',
    'City',
    'Province',
    'Price_per_year',
    'Image',
    'Description',
    'Active',
    'MinimumRent',];
}
