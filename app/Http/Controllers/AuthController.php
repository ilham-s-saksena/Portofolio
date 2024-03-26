<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request){
        $validate = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        if ($validate->fails()) {
            return response()->json(['error' => $validate->errors()], 403);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        Auth::login($user);

        $token = $user->createToken('PortoApp');

        return response()->json(
            [
                'user' => $user, 
                'token' => $token->plainTextToken,
                'access_token' => $token->accessToken
            ], 
            201
        );
    }

    public function login(Request $request){
        $emailCheck = User::where("email", $request->input('email'))->first();

        if (!$emailCheck) {
            return response()->json([
                'message' => 'email not found'
            ], 404);
        }
        if (Auth::attempt($request->only('email', 'password'))) {
            $user = Auth::user();
            $token = $user->createToken('AuthToken')->plainTextToken;

            return response()->json([
                'message' => 'Login successful',
                'token' => $token
            ]);
        } else {
            return response()->json([
                'message' => 'invalid, wrong email or password'
            ], 401);
        }
    }

    public function self_info(Request $request){
        $user = $request->user();
    
        return response()->json([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
        ], 200);
    }
}
