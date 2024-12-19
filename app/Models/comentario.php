<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class comentario extends Model
{
    use HasFactory;
    protected $fillable = [
        'comentario',
        'user_id',
        'productos_id'
        
    ];
    public function producto(): HasMany
    {
        return $this->hasMany(comentario::class);
    }
}

