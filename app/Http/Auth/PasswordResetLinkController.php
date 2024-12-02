<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\http\Requests\PasswordResetLinkRequest;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;
use App\Jobs\SendLinkEmail;
use App\Models\User;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/ForgotPassword', [
            'status' => session('status'),
        ]);
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(PasswordResetLinkRequest $request)
    {
        $request->validated();

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        /*$status = Password::sendResetLink(
            $request->only('email')
        );*/
        // SendLinkEmail::dispatch($request->only('email'));
        // SendLinkEmail::dispatch($request->email);
        // SendLinkEmail::dispatch();
        // if ($status == Password::RESET_LINK_SENT) {
        //     return back()->with('status', __($status));
        //     return $this->jsonControllerResponse(trans($status),200,true);
        // }
        // switch ($status) {
        //     case Password::RESET_LINK_SENT:
        //         return response()->json(['message' => __($status)], 200);
            
        //     case Password::RESET_THROTTLED:
        //         return response()->json(['message' => __($status)], 429);
            
        //     case Password::INVALID_USER:
        //     case Password::INVALID_TOKEN:
        //         throw ValidationException::withMessages([
        //             'email' => [trans($status)],
        //         ]);
            
        //     default:
        //         return response()->json(['message' => 'An unknown error occurred.'], 500);
        // }
        /*switch ($status) {
            case Password::RESET_LINK_SENT:
                SendLinkEmail::dispatch();
                return response()->json(['message' => 'El enlace de restablecimiento de contraseña fue enviado con éxito.'], 200);

            case Password::RESET_THROTTLED:
                return response()->json(['message' => 'Por favor, espera antes de intentar nuevamente.'], 429);

            case Password::INVALID_USER:
                return response()->json(['message' => 'No se pudo encontrar un usuario con esa dirección de correo electrónico.'], 404);

            case Password::INVALID_TOKEN:
                return response()->json(['message' => 'El token de restablecimiento de contraseña es inválido o se agoto el tiempo.'], 400);

            default:
                return response()->json(['message' => 'Ocurrió un error desconocido.'], 500);
        }*/

        // throw ValidationException::withMessages([
        //     'email' => [trans($status)],
        // ]);
       /* return response()->json([
            'errors' => [
                'email' => [trans($status)],
            ]
        ], 422);*/
        // return $this->jsonControllerResponse( "Probando",200,true);

        $user = User::where('email', $request->email)->first();
        // $token = app('auth.password.broker')->createToken($user);
        if ($user) {
            // Despachar el job
            SendLinkEmail::dispatch($request->only('email'));
            /*return response()->json([
                'message' => 'Se envio el mensaje!',
                'success' => true,
            ], 200);*/
            $response=[
                'message' => 'Se envio el mensaje!',
                'success' => true,
            ];
            return $this->jsonControllerResponse( $response,200,true);
            // Enviar el enlace de restablecimiento de contraseña
            /*$status = Password::sendResetLink(
                $request->only('email')
            );

            switch ($status) {
                case Password::RESET_LINK_SENT:
                    return response()->json(['message' => 'El enlace de restablecimiento de contraseña fue enviado con éxito.'], 200);

                case Password::RESET_THROTTLED:
                    return response()->json(['message' => 'Por favor, espera antes de intentar nuevamente.'], 429);

                case Password::INVALID_USER:
                    return response()->json(['message' => 'No se pudo encontrar un usuario con esa dirección de correo electrónico.'], 404);

                case Password::INVALID_TOKEN:
                    return response()->json(['message' => 'El token de restablecimiento de contraseña es inválido o se agotó el tiempo.'], 400);

                default:
                    return response()->json(['message' => 'Ocurrió un error desconocido.'], 500);
            }*/

            return response()->json([
                'message' => 'Se logro conectar al job',
                'success' => true,
            ], 200);
        }

        // return response()->json([
        //     'message' => 'Usuario registrado y job despachado',
        //     'success' => true,
        // ], 201);
    }
}
