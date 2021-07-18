<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Auth;
use Illuminate\Support\Str;

use Illuminate\Http\Request;
use App\Models\User;
class AuthApiController extends Controller
{

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8|regex:/^(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/|confirmed'
        ]);

        $data['password'] = bcrypt($request->password);

        $user = User::create($data);

        $token = $user->createToken('API Token')->accessToken;

        return response([ 'user' => $user, 'token' => $token]);
    }

    public function login(Request $request)

    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8|regex:/^(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/',
        ]);
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];
        // $validator = $request->validate([
            
        // ]);
        if ($validator->fails())
        {            
            $response=[
            'user' => $credentials,
            'success'=>false, 
            'message'=>$validator->errors()->all()
            ];
            return response( $response, 422);
        }

        if (!Auth()->attempt($credentials)) {
            $response=['user' => $credentials,
            'success'=>false, 
            'message'=>"Incorrect Credentials.",
            ];

            return response()->json($response,422);
        }

        $token = Auth()->user()->createToken('API Token')->accessToken;
        $response=['user' => auth()->user(),
                'success'=>true, 
                'message'=>"Login successful.",
                'token' => $token];
        
        return response()->json($response,200);

    }
    public function logout(Request $request) {
        
        // if (Auth::check()) {
        //     $token = Auth::user()->token();
        //     $token->revoke();
        //     $response=["success"=>true,"message"=>"Logout successfully."];
        //     return response()->json($response);
        // } 
        // else{ 
        //     $response=["success"=>false,"message"=>"Unauthorised."];
        //     return response()->json($response);
          
        // } 
        Auth::logout();
        $response=["success"=>true,"message"=>"Logout successfully."];
        return response()->json($response);
        // $accessToken = auth()->user()->token();
        // $token= $request->user()->tokens->find($accessToken);
        // $token->revoke();
        // return response(['message' => 'You have been successfully logged out.'], 200);
    }
}