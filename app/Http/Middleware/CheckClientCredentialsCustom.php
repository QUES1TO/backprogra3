<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Http\Middleware\Authenticate as BaseAuthenticate;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use App\Traits\JsonResponse;

class CheckClientCredentialsCustom extends BaseAuthenticate
{
    use JsonResponse;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string[]  ...$guards
     * @return mixed
     *
     * @throws \Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException
     */
    public function handle($request, Closure $next, ...$guards)
    {
        try {
            $this->authenticate($request, $guards);
        } catch (\Exception $exception) {
            // Personaliza los mensajes de error aquí según el tipo de excepción
            if ($exception instanceof UnauthorizedHttpException) {
                if($exception->getMessage()==="Token not provided")
                return $this->jsonResponse(['error' => "Token inexistente"],401,false);

                if($exception->getMessage()==="Token has expired")                
                return $this->jsonResponse(['error' => "Token expirado"],401,false);

                if($exception->getMessage()==="Could not decode token: Error while decoding from JSON")
                return $this->jsonResponse(['error' => "Token invalido"],401,false);                

                if($exception->getMessage()==="Wrong number of segments")
                return $this->jsonResponse(['error' => "Token invalido"],401,false);                  
                
            } elseif ($exception instanceof TokenInvalidException) {                
                return $this->jsonResponse(['error' => 'Token inválido.'],401,false);  
            } elseif ($exception instanceof JWTException) {
                return $this->jsonResponse(['error' => 'Error al procesar el token: ' . $exception->getMessage()],401,false);                
            }            
            // Si hay otras excepciones, puedes manejarlas aquí
            // ...

            // Si no coincide con ninguna de las excepciones anteriores, lanza la excepción original
            throw $exception;
        }

        return $next($request);
    }

    /**
     * Handle TokenExpiredException and return a custom response.
     *
     * @param \Tymon\JWTAuth\Exceptions\TokenExpiredException $exception
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function handleTokenExpired(TokenExpiredException $exception)
    {
        return response()->json(['error' => 'Token expirado.'], 401);
    }

    /**
     * Handle TokenInvalidException and return a custom response.
     *
     * @param \Tymon\JWTAuth\Exceptions\TokenInvalidException $exception
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function handleTokenInvalid(TokenInvalidException $exception)
    {
        return response()->json(['error' => 'Token inválido.'], 401);
    }

    /**
     * Handle JWTException and return a custom response.
     *
     * @param \Tymon\JWTAuth\Exceptions\JWTException $exception
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function handleJWTException(JWTException $exception)
    {
        return response()->json(['error' => 'Error al procesar el token: ' . $exception->getMessage()], 401);
    }
}
