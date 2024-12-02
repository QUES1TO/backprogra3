<?php

namespace App\Http\Controllers;

use App\Models\productoCar;
use App\Models\producto;
use App\Models\repuestoCar;
use App\Models\repuesto;
use App\Models\carito;
use Illuminate\Http\Request;

class CaritoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $carito = carito::get(['id','total']);
        return $this->jsonControllerResponse( $carito,200,true);
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
    public function store(Request $request)
    {
        $carito=null;
        $inputs = $request->all();
        
        $inputs["total"] = 0;
        if($request->input('id')==0)
        {
            $carito =carito::create($inputs);
        }
        else{
            $carito =carito::findOrFail($request->input('id'));
        }
       
        if(productoCar::where('producto_id', $request->input('producto_id'))->where('carito_id','=',$carito->id)->exists())
            {
                $productoCars = productoCar::where('producto_id', $request->input('producto_id'))->where('carito_id','=',$carito->id)->get()->first();
                $amountToAdd = intval($request->input('amount'));
                $currentAmount = intval($productoCars->amount);
                $productoCars->amount=$amountToAdd+$currentAmount;
                $productoCars->save();
            }
            else{
                $productoCars = productoCar::create([
                    "amount"=>$request->input('amount'), //cantidad
                    "producto_id"=>$request->input('producto_id'),
                    "carito_id"=> $carito->id
                ]);
            }
        $productoCars = productoCar::where("carito_id","=",$carito->id)->get();
        $total=0;
        foreach($productoCars as $productoCar)
        {
            $producto = producto::findOrFail($productoCar->producto_id);
            $subtotal = $producto->precio * $productoCar->amount;
            $total = $total + $subtotal;
        }
        $carito->total=$total;
        $carito->save();
        $respuesta = [
            "carito_id"=> $carito->id
        ];
        return $this->jsonControllerResponse( $respuesta,201,true);
    }



    public function store2(Request $request)
    {
        $carito=null;
        $inputs = $request->all();
        
        $inputs["total"] = 0;
        if($request->input('id')==0)
        {
            $carito =carito::create($inputs);
        }
        else{
            $carito =carito::findOrFail($request->input('id'));
        }
      
        if(repuestoCar::where('repuesto_id', $request->input('repuesto_id'))->where('repuesto_id','=',$carito->id)->exists())
            {
                $repuestoCars = repuestoCar::where('repuesto_id', $request->input('repuesto_id'))->where('repuesto_id','=',$carito->id)->get()->first();
                $amountToAdd = intval($request->input('amount'));
                $currentAmount = intval($repuestoCars->amount);
                $repuestoCars->amount=$amountToAdd+$currentAmount;
                $repuestoCars->save();
            }
            else{
                $repuestoCars = repuestoCar::create([
                    "amount"=>$request->input('amount'), //cantidad
                    "repuesto_id"=>$request->input('repuesto_id'),
                    "carito_id"=> $carito->id
                ]);
            }
        $repuestoCars = repuestoCar::where("carito_id","=",$carito->id)->get();
        $total=0;
        foreach($repuestoCars as $repuestoCar)
        {
            $repuesto = repuesto::findOrFail($repuestoCar->repuesto_id);
            $subtotal = $repuesto->precio * $repuestoCar->amount;
            $total = $total + $subtotal;
        }
        $carito->total=$total;
        $carito->save();
        $respuesta = [
            "carito_id"=> $carito->id
        ];
        return $this->jsonControllerResponse( $respuesta,201,true);
    }






    /**
     * Display the specified resource.
     */
    public function show(carito $carito)
    {
        return $this->jsonControllerResponse( $carito->products,200,true);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(carito $carito)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, carito $carito)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(carito $carito)
    {
        //
    }
}
