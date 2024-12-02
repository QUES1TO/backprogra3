<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductoRegisterRequest extends BaseFormRequest
{    
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [            
            'nombre' => 'required',     
            'url_imagen' => 'required|image|mimes:jpeg,png,jpg,gif|max:4048',       
            'marca' => 'required',
            'kilometraje' => 'required',
            'año' => 'required',
            'combustible' => 'required',
            'transmision' => 'required',
            'motor' => 'required',
            'color' => 'required',
            'puertas' => 'required',
            'precio' => 'required',
            'categoria_id' => 'required',  
        ];
    }
    public function messages()
    {
        return [
           /* 'nombre.required' => 'El campo nombre  es obligatorio.',   */
            /* 'calida.required' => 'El campo calidad  es obligatorio.',*/
            /* 'modelo.required' => 'El campo modelo  es obligatorio.',*/
             /*'lado.required' => 'El campo lado  es obligatorio.',*/
             /*'stock.required' => 'El campo stock  es obligatorio.',*/
            /* 'descripcion.required' => 'El campo descripcion  es obligatorio.',*/
            /* 'precio.required' => 'El campo precio  es obligatorio.',*/
            /* 'categoria_id.required' => 'El campo categoria_id  es obligatorio.',*/
            /* 'url_imagen.required' => 'El campo url_imagen  es obligatorio.'*/
        ];
    }
}
