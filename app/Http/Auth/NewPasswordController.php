<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\http\Requests\NewPasswordRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class NewPasswordController extends Controller
{
    /**
     * Display the password reset view.
     */
    public function create(Request $request): Response
    {
        return Inertia::render('Auth/ResetPassword', [
            'email' => $request->email,
            'token' => $request->route('token'),
        ]);
    }

    /**
     * Handle an incoming new password request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(NewPasswordRequest $request)
    {
        // $request->validate([
        //     'token' => 'required',
        //     'email' => 'required|email',
        //     'password' => ['required', 'confirmed', Rules\Password::defaults()],
        // ]);
        $request->validated();

        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        // If the password was successfully reset, we will redirect the user back to
        // the application's home authenticated view. If there is an error we can
        // redirect them back to where they came from with their error message.
        // if ($status == Password::PASSWORD_RESET) {
        //     return redirect()->route('login')->with('status', __($status));
        //     return $this->jsonControllerResponse($status,200,true);  
        // }
        switch ($status) {
            case Password::INVALID_USER:
                //return response()->json(['message' => 'No se pudo encontrar un usuario con esa dirección de correo electrónico.'], 404);
                return $this->jsonControllerResponse( ['message' => 'No se pudo encontrar un usuario con esa dirección de correo electrónico.'],422,false);

            case Password::PASSWORD_RESET:
                //return response()->json(['message' => 'La contraseña se ha restablecido con éxito.'], 200);
                return $this->jsonControllerResponse( ['message' => 'La contraseña se ha restablecido con éxito.'],200,true);

            case Password::INVALID_TOKEN:
                //return response()->json(['message' => 'El token de restablecimiento de contraseña es inválido o se agoto el tiempo.'], 400);
                return $this->jsonControllerResponse( ['message' => 'El token de restablecimiento de contraseña es inválido o se agoto el tiempo.'],403,false);

            default:
                //return response()->json(['message' => 'Ocurrió un error desconocido.'], 500);
                return $this->jsonControllerResponse( ['message' => 'Ocurrió un error desconocido.'],403,false);
        }

        // throw ValidationException::withMessages([
        //     'email' => [trans($status)],
        // ]);
        return response()->json([
            'errors' => [
                'email' => [trans($status)],
            ]
        ], 422);
    }
}
