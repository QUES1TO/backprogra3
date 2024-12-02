<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;
use App\Http\Requests\CategoriaRegisterRequest;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //$categoria = Categoria::all();
        $categoria = Categoria::get(['id','nombre','cc','modelo','marca','url_imagen','stock','descripcion','precio']);
        return $this->jsonControllerResponse( $categoria,200,true);
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
    public function store(CategoriaRegisterRequest $request)
    {
        $validated = $request->validated();
        $categoria = Categoria::create($validated);
        $respuesta = [
            "mensaje"=> "Categoria creada con exito!!!!"
        ];
        return json_encode($respuesta);
    }

    /**
     * Display the specified resource.
     */
    public function show(Categoria $categoria)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Categoria $categoria)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Categoria $categoria)
    {
        // editar categoria
        $user=auth('api')->user();
        $categoria = categoria::where('id', $categoria->id)->first();
        $categoria->nombre = $request['nombre'];
        $categoria->save();
        $respuesta = [
            "mensaje"=> "Categoria editada con exito!!!!"
        ];
        return $this->jsonControllerResponse( $respuesta,200,true);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Categoria $categoria)
    {
        // eliminar la categoria
        $categoria->delete();
        $respuesta = [
            "mensaje"=> "Categoria eliminada con exito!!!!"
        ];
        return $this->jsonControllerResponse( $respuesta,200,true);
    }
}