<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use App\Http\Requests\ProductoRegisterRequest;
use Illuminate\Support\Facades\Storage;
use App\Models\Categoria;


class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        $producto = Producto::where('categoria_id','=',$request->get('id_categoria'))->with('categoria')->get();
        return $this->jsonControllerResponse( $producto,200,true);

    }
    public function index2(Request $request)
    {
        //
        $producto = Producto::with('categoria')->get();
        return $this->jsonControllerResponse( $producto,200,true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductoRegisterRequest $request)
    {
        //
        $validated = $request->validated();
        $user = auth('api')->user();
        //$producto = producto ::create($validated);
    
        // Manejo de la primera imagen
        $image = $request->file('url_imagen');
        $imageName = time() . '.' . $image->extension();
        Storage::disk('public')->put($imageName, file_get_contents($image));
    
        // Manejo de url_imagen2
        $image2 = $request->file('url_imagen2');
        if ($image2) {
            $imageName2 = time() . '_2.' . $image2->extension();
            Storage::disk('public')->put($imageName2, file_get_contents($image2));
        }
    
        // Manejo de url_imagen3
        $image3 = $request->file('url_imagen3');
        if ($image3) {
            $imageName3 = time() . '_3.' . $image3->extension();
            Storage::disk('public')->put($imageName3, file_get_contents($image3));
        }
    
        // Manejo de url_imagen4
        $image4 = $request->file('url_imagen4');
        if ($image4) {
            $imageName4 = time() . '_4.' . $image4->extension();
            Storage::disk('public')->put($imageName4, file_get_contents($image4));
        }
    
        $data = $request->except(['url_imagen', 'url_imagen2', 'url_imagen3', 'url_imagen4']);
        $producto = producto::create($data);
        $producto->url_imagen = $imageName;
        if (isset($imageName2)) {
            $producto->url_imagen2 = $imageName2;
        }
        if (isset($imageName3)) {
            $producto->url_imagen3 = $imageName3;
        }
        if (isset($imageName4)) {
            $producto->url_imagen4 = $imageName4;
        }
        $producto->save();
    
        $respuesta = [
            "mensaje" => "Producto creado con éxito!!!!"
        ];
        return $this->jsonControllerResponse($respuesta, 200, true);
    }
    

    /**
     * Display the specified resource.
     */
    public function show(producto $producto)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(producto $producto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
   public function update(Request $request, Producto $producto)
{
    

    $image = $request->file('url_imagen');
    $imageName = time() . '.' . $image->extension();
    Storage::disk('public')->put($imageName, file_get_contents($image));
    
    $image2 = $request->file('url_imagen2');
    $imageName2 = time() . '.' . $image2->extension();
    Storage::disk('public')->put($imageName2, file_get_contents($image2));

    $image3 = $request->file('url_imagen3');
    $imageName3 = time() . '.' . $image3->extension();
    Storage::disk('public')->put($imageName3, file_get_contents($image3));

    $image4 = $request->file('url_imagen4');
    $imageName4 = time() . '.' . $image4->extension();
    Storage::disk('public')->put($imageName4, file_get_contents($image4));


    // Actualizar los datos del producto
    $producto->nombre = $request->input('nombre');
    $producto->marca = $request->input('marca');
    $producto->kilometraje = $request->input('kilometraje');
    $producto->año = $request->input('año');
    $producto->combustible = $request->input('combustible');
    $producto->transmision = $request->input('transmision');
    $producto->motor = $request->input('motor');
    $producto->color = $request->input('color');
    $producto->puertas = $request->input('puertas');
    $producto->precio = $request->input('precio');
    $producto->categoria_id = $request->input('categoria_id');
    $producto->user_id = $request->input('user_id');
    $producto->save();
    $respuesta = [
        "mensaje"=> "producto actualizado"
    ];
    // Responder con un mensaje de éxito
    return $this->jsonControllerResponse($respuesta, 200, true);
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(producto $producto)
    {
        //eliminar el producto
         $producto->delete();
         $respuesta = [
             "mensaje"=> "Producto eliminado con exito!!!!"
         ];
         return $this->jsonControllerResponse( $respuesta,200,true);
    }
}
