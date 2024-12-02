<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use App\Http\Requests\BrandRegisterRequest;
use Illuminate\Support\Facades\Storage;
class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(BrandRegisterRequest $request)
    {
        $validated = $request->validated(); 
        $validated = $request->only(["brand_name"]);
        $brand = Brand::create($validated);
        $image = $request->file('brand_url_logo');
        $imageName = time() . '.' . $image->extension();
        Storage::disk('public')->put($imageName, file_get_contents($image));

        $brand->brand_url_logo = $imageName;
        $brand->save();
        $respuesta = [
            "mensaje"=> "Marca creada con exito!!!!"
        ];        
        return $this->jsonControllerResponse( $respuesta,201,true);
    }

    /**
     * Display the specified resource.
     */
    public function show(Brand $brand)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Brand $brand)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Brand $brand)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Brand $brand)
    {
        //
    }
}
