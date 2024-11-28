<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use App\Traits\JsonResponse;
use Illuminate\Http\Exceptions\HttpResponseException;

class Handler extends ExceptionHandler
{
    use JsonResponse;
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];    
        
    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });        
        $this->renderable(function (\Spatie\Permission\Exceptions\UnauthorizedException $e, $request) {
            $body = [
                'responseMessage' => 'No tienes los permisos necesarios para usar esta funcion',
                'responseStatus'  => 403,
            ];
            return $this->jsonResponse($body,403,false);
            /*return response()->json([
                'responseMessage' => 'No tienes los permisos necesarios para usar esta funcion',
                'responseStatus'  => 403,
            ]);*/
        });
    }    

}
