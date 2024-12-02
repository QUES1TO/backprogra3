<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class productoCar extends Model
{
    use HasFactory;
    protected $fillable = [
        'producto_id',
        'amount',
        'carito_id',
    ];
}
