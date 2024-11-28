<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRegisterRequest;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //extraer los productos en json
        $products = Product::with('categoria')->get();
        return $this->jsonControllerResponse( $products,200,true);


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
    public function store(ProductRegisterRequest $request)
    {
        //guardar los productos en la base de datos
        $validated = $request->validated();
        $validated = $request->except(["product_url_image"]);
        $product = Product::create($validated);
        $image = $request->file('product_url_image');
        $imageName = time() . '.' . $image->extension();
        Storage::disk('public')->put($imageName, file_get_contents($image));        
        $product->product_url_image=$imageName;
        $product->save();
        $respuesta = [
            "mensaje"=> "producto creado con exito!!!!"
        ];
        return $this->jsonControllerResponse( $respuesta,201,true);
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {                                   
        $image = $request->file('product_url_image');
        $imageName = time() . '.' . $image->extension();
        Storage::disk('public')->put($imageName, file_get_contents($image));        
        $product->product_url_image=$imageName;
        $product->product_name=$request->input('product_name');
        $product->product_price=$request->input('product_price');
        $product->categoria_id=$request->input('categoria_id');
        $product->save();
        $respuesta = [
            "mensaje"=> "producto actualizado"
        ];
        return $this->jsonControllerResponse( $respuesta,200,true);

   }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
