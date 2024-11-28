<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Categoria extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'nombre'
    ];

    public function adornos(): HasMany
    {
        return $this->hasMany(Adorno::class);
    }
    public function productos(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
