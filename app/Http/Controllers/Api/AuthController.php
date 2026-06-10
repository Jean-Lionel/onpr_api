<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function register(Request $request)
    {
        // Validate request data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|min:6',
        ]);
        // Return errors if validation error occur.
        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json([
                'error' => $errors
            ], 400);
        }

        // Create user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'telephone' => $request->telephone,
            'description' => $request->description,
            'mobile' => $request->mobile,
            'password' => Hash::make($request->password)
        ]);
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'data' => Auth::user(),
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    public function login(Request $request)
    {
        $login = $request->email;
        $field = 'email';

        if (filter_var($login, FILTER_VALIDATE_EMAIL)) {
            $field = 'email';
        } elseif (preg_match('/^[0-9]+$/', $login)) {
            // Check if it's a matricule or a phone number
            $user = User::where('numero_matricule', $login)
                ->orWhere('telephone', $login)
                ->orWhere('mobile', $login)
                ->first();

            if ($user) {
                if ($user->numero_matricule == $login) {
                    $field = 'numero_matricule';
                } elseif ($user->telephone == $login) {
                    $field = 'telephone';
                } else {
                    $field = 'mobile';
                }
            }
        }

        if (!Auth::attempt([$field => $login, 'password' => $request->password])) {
            return response()->json([
                'message' => 'Invalid login details'
            ], 401);
        }

        $user = User::where($field, $login)->firstOrFail();

        if ($user->is_active == 0) {
            return response()->json([
                'message' => "Vôtre compte a été bloqué; Veuillez consulter le service Informatique de ONPR !!!"
            ], 401);
        }
        
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'data' => [
                "user" => Auth::user(),
                "role" => $user->role
            ],
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    public function me(Request $request)
    {
        return $request->user();
    }

    public function logout(Request $request)
    {
        $user = Auth::user();
        if ($user) {
            $user->tokens()->delete();
        }
        return response()->json([
            'success' => 'Successfully logged out'
        ]);
    }
}
