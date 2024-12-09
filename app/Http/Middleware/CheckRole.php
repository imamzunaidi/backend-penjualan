<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Ambil user yang terautentikasi menggunakan JWT
        $user = JWTAuth::parseToken()->authenticate();

        // Cek apakah user memiliki salah satu role yang dibolehkan
        if (!in_array($user->role, $roles)) {
            return response()->json(['error' => 'Forbidden'], 403);
        }

        return $next($request);
    }
}