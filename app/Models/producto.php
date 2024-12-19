<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Producto extends Model
{
    use HasFactory;
    protected $fillable = [
        'nombre',
        'marca',
        'kilometraje',
        'año',
        'combustible',
        'transmision',
        'motor',
        'color',
        'puertas',
        'precio',
        'url_imagen',
        'url_imagen2',
        'url_imagen3',
        'url_imagen4',
        'categoria_id',
        'user_id'
    ];
    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class);
    }
    public function carts(): BelongsToMany
    {
        return $this->belongsToMany(Cart::class,'selected_productos')->withPivot('amount');
    }
}
