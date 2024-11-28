<?php

namespace App\Traits;

trait JsonResponse
{
    protected  function jsonResponse($jsonBody,$httpCode,$success)
    {
        return response()->json(
            [
                'success' => $success,
                'code' => $httpCode,
                'body' => $jsonBody
            ],$httpCode
            );
    }

    // Puedes agregar más métodos y propiedades aquí
}
