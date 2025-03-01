<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    #FUNCTION TO CREATE USER 
     function createUser(Request $request){
     $validator = Validator::make($request->all(), [
        'name' => 'required',
        'email' => 'required|email|unique:users',
        'password' => 'required',
     ]);

     if($validator->fails())
     {
        return response()->json(['error' => $validator->errors(),
         "mes"=>"validation error occured"
    ], 400);
     }

        $user = User::create(
            [
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),

            ]
            );

        if($user->id)
        {
            return response()->json(['message' => 'User created successfully'], 200);
        }else{
            return response()->json(['message' => 'Failed to create user'], 400);
        }
     
       
    

     }


     # to show the user
  function showUser(){
    $users = User::all();
    return response()->json(['users' => $users,"msg"=>count($users)." users found"], 200);
  }
}
