<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
class Product extends Model
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
        'product_url_image',
        'categoria_id'
    ];
    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class);
    }
    public function carts(): BelongsToMany
    {
        return $this->belongsToMany(Cart::class,'selected_products')->withPivot('amount');
    }
    //Relacion uno a muchos inversa (relacion polimorfica
}
