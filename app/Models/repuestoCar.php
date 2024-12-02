<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class repuestoCar extends Model
{
    use HasFactory;
    protected $fillable = [
        'repuesto_id',
        'amount',
        'carito_id',
    ];
}
