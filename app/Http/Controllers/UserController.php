<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthenticateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function authenticate(AuthenticateUserRequest $request): JsonResponse
    {
        $user = User::where('email', $request->input('email'))->first();

        if (! $user || ! password_verify($request->input('password'), $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $apiToken = Str::random(80);
        $user->api_token = Hash::make($apiToken);
        $user->save();

        return response()->json(['token' => $apiToken]);
    }

    public function profile(Request $request): JsonResponse
    {
        return response()->json(UserResource::make($request->user()));
    }
}
