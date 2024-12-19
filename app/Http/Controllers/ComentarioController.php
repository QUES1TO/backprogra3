<?php

namespace App\Http\Controllers;

use App\Models\comentario;
use Illuminate\Http\Request;
use App\Http\Requests\ComentarioRegisterRequest;
class ComentarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        $comentario = Comentario::where('user_id','=',$request->get('user_id'))->with('user')->get();
        return $this->jsonControllerResponse( $comentario,200,true);

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
    public function store(ComentarioRegisterRequest $request)
    {
        $validated = $request->validated();
    
        // Crear el comentario
        $comentario = Comentario::create($validated);
    
        // Responder con éxito
        $respuesta = [
            "mensaje" => "Comentario creado con éxito!",
            "comentario" => $comentario
        ];
    
        return response()->json($respuesta, 201);
    }
    
    /**
     * Display the specified resource.
     */
    public function show(comentario $comentario)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(comentario $comentario)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, comentario $categoria)
    {
        // editar categoria
        $user=auth('api')->user();
        $comentario = categoria::where('id', $comentario->id)->first();
        $comentario->nombre = $request['comentario'];
        $comentario->save();
        $respuesta = [
            "mensaje"=> "comentario editada con exito!!!!"
        ];
        return $this->jsonControllerResponse( $respuesta,200,true);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(comentario $comentario)
    {
        //
    }
}
