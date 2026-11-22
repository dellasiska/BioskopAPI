<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;

class BasicAuth
{
    public function handle($request, Closure $next)
    {
        $username = $request->getUser();
        $password = $request->getPassword();

        $user = User::where('username', $username)->first();

        if (!$user || !password_verify($password, $user->password)) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }

        return $next($request);
    }
}