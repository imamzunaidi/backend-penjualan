<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    // Fungsi untuk login dan menghasilkan JWT Token
    public function login(Request $request)
    {

        $request->validate([
            'email' => 'required|email',
            // 'password' => 'required|min:6',
        ]);


        $credentials = $request->only('email', 'password');

        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'Could not create token'], 500);
        }

        $user = JWTAuth::user();

        
        return response()->json([
            'user' => $user,
            'token' => $token,
        ]);
    }

    // Fungsi untuk logout (invalidasi token)
    public function logout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());
        return response()->json(['message' => 'Successfully logged out']);
    }


    public function register(Request $request)
    {

       
        // $request->validate([
        //     'name' => 'required|string|max:255',
        //     'email' => 'required|string|email|max:255|unique:users',
        //     'password' => 'required|string|min:6',
        //     'role' => 'required|in:admin,pelanggan',  // Validasi role
        // ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,  // Menetapkan role
        ];
        // Membuat pengguna baru dengan role
        $user = User::create($data);

        // $token = JWTAuth::fromUser($user);

        return response()->json([
            'status' => 'success',
            'message' => 'cart retrieved successfully',
            'data' => $user
        ]);
    }

}
