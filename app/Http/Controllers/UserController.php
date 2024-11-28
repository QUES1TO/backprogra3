<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Seller;
use App\http\Requests\UserRegisterRequest;
use App\http\Requests\UserSellerRegisterRequest;
use App\http\Requests\UserLoginRequest;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
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
        return $this->jsonControllerResponse( $respuesta,201,true);
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
                "email"=>$user->email,
                "token"=>$token,
                "id" =>$user->id,
                "role"=>$user->getRoleNames()[0]
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
    function index(Request $request)
    {
        $list = [
            "primero" => "mi dato"
        ];
        return json_encode($list);
    }                                                                                                                                
}
