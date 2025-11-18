<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register (Request $request){
        $request->validate([
            'name'=>'required',
            'email'=>'required|email',
            'password'=>'required|min:6'
        ]);
        $user= User::create(
            [
                'name' =>$resquest->name,
                'email'=>$request->email,
                'password'=>Hash::make($request->password)

            ]
            );
            $token= $user->createToken('app_token')->plainTextToken;
            return response()->json(['message'=>'User registered successfully','token'=>$token,'user'=> $user],201);

    }
    public function login (Request $request){
        $request->validate([
            'email'=>'required|email',
            'password'=>'required|min:6'
        ]);
        $user = User::where('email',$request->email)->first();
        if (!$user ||!Hash::check ($request->password,$user->password)){
            return response()->json(['message'=>'Invalid Credentials'],401);
            
        }
        $token = $user->createToken('app_token')->plainTextToken;
        return response()->json(['message'=>'Login Successfull','token'=>$token,'user'=>$user],200);
  
     
    }
    public function logout (Request $request){
         $request->user()->token()->delete();
         return response()->json(['message'=>'Logged out successfully'],200);
    }
  

}
