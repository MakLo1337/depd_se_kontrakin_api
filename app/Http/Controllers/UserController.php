<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function login(){
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){
         $user = Auth::user();
         $success['token'] = $user->createToken('appToken')->accessToken;
         return response()->json([
          'success' => true,
          'token' => $success,
          'user' => $user,
          'role' => Auth::user()->role,
         ]);
        } else{
         return response()->json([
          'success' => false,
          'message' => 'Invalid Email or Password',
         ], 401);
        }
    }
      
    
    public function register(Request $request){
        $validator = Validator::make($request->all(), [
         'name' => ['required', 'string', 'max:255'],
         'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
         'password' => ['required', 'string', 'min:8'],
         'role' => ['required', 'string'],
         'phone' => ['required', 'string', 'max:255'],
        ]);
        if($validator->fails()){
         return response()->json([
          'success' => false,
          'message' => $validator->errors(),
         ], 401);
        }
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] = $user->createToken('appToken')->accessToken;
        return response()->json([
         'success' => true,
         'token' => $success,
         'user' => $user,
         'role' => $request->role,
        ]);
    }

    public function logout(Request $request){
        if(Auth::user()){
         $user = Auth::user()->token();
         $user->revoke();
      return response()->json([
          'success' => true,
          'message' => 'Logout successfully',
         ]);
        } else{
         return response()->json([
          'success' => false,
          'message' => 'Unable to Logout',
         ]);
        }
       }
}
