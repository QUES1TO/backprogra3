<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Traits\JsonResponse as CustomJsonResponse;

class BaseFormRequest extends FormRequest
{
    use CustomJsonResponse;
    function failedValidation(Validator $validator)
    {
        $response = $this->jsonResponse([$validator->errors()],422,false);
        
        throw new HttpResponseException($response);
    }
}
