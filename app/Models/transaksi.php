<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksis';

    protected $fillable = ['lesseeID',
    'lessorID',
    'kontrakanID',
    'startDate',
    'endDate',
    'rentDuration',
    'approved',];
}
