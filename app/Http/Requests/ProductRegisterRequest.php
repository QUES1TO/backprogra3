<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRegisterRequest extends BaseFormRequest
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
            'product_url_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:4048',       
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
            'nombre.required' => 'El campo nombre de producto es obligatorio.'            
        ];
    }
}
