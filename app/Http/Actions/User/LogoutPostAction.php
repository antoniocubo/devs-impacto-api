<?php

namespace App\Http\Actions\User;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class LogoutPostAction
{

    public function __invoke(): JsonResponse
    {
        Auth::user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out']);
    }

}
