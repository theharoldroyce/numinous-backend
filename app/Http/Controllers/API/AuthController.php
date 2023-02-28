<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use  Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fname' =>'required|max:191',
            'lname' =>'required|max:191',
            'email' =>'required|email|max:191|unique:users,email',
            'password' =>'required|confirmed|min:8',
            'password_confirmation' =>'required',
        ]);

        if($validator->fails())
        {
            return response()->json([
                'validation_errors'=>$validator->messages(),
            ]);
        }
        else
        {
            $user = User::create([
                'fname' =>$request->fname,
                'lname' =>$request->lname,
                'email' =>$request->email,
                'password' =>Hash::make($request->password),
            ]);

            $token = $user->createToken($user->email.'_Token')->plainTextToken;

            return response()->json([
                'status'=>200,
                'username'=>$user->email,
                'token'=>$token,
                'message'=>'Registered Successfuly',
            ]);
        }
    }


    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'=>'required',
            'password'=>'required',
        ]);

        if($validator->fails())
        {
            return response()->json([
                'validation_errors'=>$validator->messages(),
            ]);
        }
        else
        {
            $user = User::where('email', $request->email)->first();

            if (! $user || ! Hash::check($request->password, $user->password)) {
                return response()->json([
                    'status'=>401,
                    'message'=>'Invalid Credentials',
                ]);
            }
            else
            {
                $token = $user->createToken($user->email.'_Token')->plainTextToken;

                return response()->json([
                    'status'=>200,
                    'username'=>$user->email,
                    'token'=>$token,
                    'message'=>'Logged In Successfuly',
                ]);
            }
        }
    }


    public function logout()
    {
        auth()->user()->tokens()->delete();
        return response()->json([
            'status' =>200,
            'message' => 'Logged Out Successfuly',
        ]);
    }

}
