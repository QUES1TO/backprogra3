<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;
use App\Http\Requests\CategoriaRegisterRequest;
use Illuminate\Support\Facades\Storage;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //$categoria = Categoria::all();
        $categoria = Categoria::get(['id','nombre']);
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

        $validated = $request->only(["nombre"]);
        $categoria = Categoria::create($validated);     
        $categoria->save();
        $respuesta = [
            "mensaje"=> "Categoria creada con exito!!!!"
        ];        
        return $this->jsonControllerResponse( $respuesta,200,true);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Categoria $categoria)
    {
        //
    }
}
