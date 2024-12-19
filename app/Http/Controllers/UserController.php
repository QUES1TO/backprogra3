<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\http\Requests\UserRegisterRequest;
use App\http\Requests\UserLoginRequest;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index2()
    {
        //$categoria = Categoria::all();
        $categoria = Categoria::get(['id','comentario']);
        return $this->jsonControllerResponse( $categoria,200,true);
    }

    function signUp(UserRegisterRequest $request)
    {
        $validated = $request->validated();
        $user = User::create($validated);
        $user->password=Hash::make($validated['password']);
        $user->assignRole('Admin');
        $user->save();
        $respuesta = [
            "mensaje"=> "Usuario creado con exito!!!!"
        ];
        return json_encode($respuesta);
    }

    function signUpSeller(UserSellerRegisterRequest $request)
    {        
        $validated = $request->validated();
        $user = User::create($validated);
        $user->password=Hash::make($validated['password']);
        $user->assignRole('Seller');
        $user->save();
        Seller::create([
            "name"=>$request->input('name'),
            "last_name"=>$request->input('last_name'),
            "kind"=>$request->input('kind'),
            "status"=>$request->input('status'),
            "user_id"=>$user->id
        ]);
        $respuesta = [
            "mensaje"=> "Usuario vendedor creado con exito!!!!"
        ];
        return $this->jsonControllerResponse( $respuesta,201,true);
    }

    function login(UserLoginRequest $request)
    {
        $validated = $request->validated();
        $token = auth('api')->attempt($validated);
        if($token)
        {
            $user=auth('api')->user();
            $response = [
                "name" =>$user->name,
                "email"=>$user->email,
                "token"=>$token
            ];
            return $this->jsonControllerResponse( $response,200,true);
        }
        else
        {
            $response = [
                "mensaje"=>"Email o password incorrectos"
            ];
            return $this->jsonControllerResponse( $response,403,false);
        }
        //return json_encode($response);
    }
    public function index()
    {
        $user = User::all();
        return $this->jsonControllerResponse($user, 201 , true );
    }

    function update(UserEditRequest $request,$id)
    {
        if($User = User::find($id))
        {
            $User->name = $request->input('name');
            $User->email = $request->input('email');
            $User->password = Hash::make($request->input('password'));
            $User->apellido = Hash::make($request->input('apellido'));
            $User->direccion = Hash::make($request->input('direccion'));
            $User->telefono = Hash::make($request->input('telefono'));
            $User->save();
            $respuesta = [
                "mensaje"=> "Usuario editado con exito!!!!"
            ];
            return $this->jsonControllerResponse( $respuesta,200,true);
        }
        else
        {
            $respuesta = [
                "mensaje"=> "Usuario no encontrado!!!!"
            ];
            return $this->jsonControllerResponse( $respuesta,404,false);
        }
    }

    
    public function destroy(user $User)
    {
        //eliminar el producto
         $User->delete();
         $respuesta = [
             "mensaje"=> "usuario eliminado con exito!!!!"
         ];
         return $this->jsonControllerResponse( $respuesta,200,true);
    }
}
