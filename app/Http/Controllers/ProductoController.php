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
        $user=auth('api')->user();
        //$producto = producto ::create($validated);

        $image = $request->file('url_imagen');
        $imageName = time() . '.' . $image->extension();
        Storage::disk('public')->put($imageName, file_get_contents($image));

        $data = $request->except('url_imagen');
        $producto = producto ::create($data);
        $producto ->url_imagen = $imageName;
        $producto->save();
        $respuesta = [
            "mensaje"=> "Producto creado con exito!!!!"
        ];
        return $this->jsonControllerResponse( $respuesta,200,true);
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
    public function update(Request $request, producto $producto)
    {
        $image = $request->file('url_imagen');
         $imageName = time() . '.' . $image->extension();
         Storage::disk('public')->put($imageName, file_get_contents($image));        
         $producto->url_imagen=$imageName;
         $producto->nombre=$request->input('nombre');
         $producto->calidad=$request->input('calidad');
         $producto->modelo=$request->input('modelo');
         $producto->lado=$request->input('lado');
         $producto->stock=$request->input('stock');
         $producto->descripcion=$request->input('descripcion');
         $producto->precio=$request->input('precio');
         $producto->categoria_id=$request->input('categoria_id');
         $producto->save();
         $respuesta = [
             "mensaje"=> "producto actualizado"
         ];
         return $this->jsonControllerResponse( $respuesta,200,true);
         
   
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
