<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Traits\JsonResponse;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests,JsonResponse;

    function jsonControllerResponse($jsonBody,$httpCode,$success)
    {
        return $this->jsonResponse($jsonBody,$httpCode,$success);
    }
}
