<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class ApiAuthentication
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (empty($request->header('Authorization'))) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $token = $request->header('Authorization');
        $token = str_replace('Bearer ', '', $token);

        $user = User::where('api_token', '!=', null)->get()->first(function ($user) use ($token) {
            return Hash::check($token, $user->api_token);
        });

        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        auth()->login($user);

        return $next($request);
    }
}
