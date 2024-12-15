<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class UserLoginController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if ($user->is_admin) {
                return response()->json([
                    'message' => 'Access restricted to admin users only',
                ], 403);
            }

            $token = $user->createToken('UserToken')->accessToken;

            return response()->json([
                'message' => 'Login successful',
                'access_token' => $token,
            ]);
        }

        return response()->json([
            'message' => 'Invalid email or password',
        ], 401);
    }
}

