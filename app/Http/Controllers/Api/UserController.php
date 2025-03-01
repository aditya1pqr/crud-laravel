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

  function showUserdeatils($id)
  {
    $user = User::find($id);
    if($user){
            return response()->json(['user' => $user,"msg"=>"user found"], 200);
        }else{
            return response()->json(['message' => 'User not found'], 404);
        }
  }


  # upadte user
  function updateUser(Request $req ,$id)
  {
    $user = User::find($id);
    if(!$user){
        return response()->json(['message' => 'User not found'], 404);
    }
    $validator = Validator::make($req->all(), [
        'name' => 'required',
        'email' => 'required|email|unique:users,email,'.$id,
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
            }

            $user->name= $req->name;
            $user->email= $req->email;
            $user->save();
            return response()->json(['message' => 'User updated successfully'], 200);
          
    }

    function deleteUser($id){
        $user = User::find($id);
        if($user){
            $user->delete();
            return response()->json(['message' => 'User deleted successfully'], 200);
            }else{
                return response()->json(['message' => 'User not found'], 404);
                }
                
    }
}
