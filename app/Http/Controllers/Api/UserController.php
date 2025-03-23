<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\LogUserRequest;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;

class UserController extends Controller
{
    public function register(RegisterRequest $request)
    {
        try {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password, [
                'rounds' => 12
            ]);

            $user->save();
            return response()->json([
                'status_code' => 200,
                'status_message' => 'Utilisateur enrégistré',
                'user' => $user
            ]);
        } catch (\Exception $e) {
            return response()->json($e);
        }
    }


    // user connexion 
    public function login(LogUserRequest $request)
    {
        if (auth()->attempt($request->only(['email', 'password']))) { 
            $user = auth()->user(); 
            $token = $user->createToken('MA_CLE_SECRETE_VISIBLE_UNIQUEMENT_AU_BACKEND')->plainTextToken;

            return response()->json([ 
                'status_code' => 200,
                'status_message' => 'Utilisateur connecté', 
                'user' => $user,
                'token' => $token
            ]);
        } else {
            return response()->json([ 
                'status_code' => 403,
                'status_message' => 'Information non valide'
            ]);
        }
    }
}
