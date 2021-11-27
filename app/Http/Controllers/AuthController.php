<?php

namespace App\Http\Controllers;

use App\Models\User;
use Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function login(): Response|array
    {
        $data = validator(request()->all(), [
            'email' => ['required', 'email'],
            'password' => ['required'],
        ])->validated();

        $user = User::whereEmail($data['email'])->firstOrFail();
        if (!Hash::check($data['password'], $user->getAuthPassword())) {
            return $this->respondUnAuthenticated('Password mismatch');
        }

        return [
            'token' => $user->createToken(time())->plainTextToken,
        ];
    }

    public function logout(): Response
    {
        Auth::user()->currentAccessToken()->delete();

        return $this->respondOk('Successful logout');
    }
}
