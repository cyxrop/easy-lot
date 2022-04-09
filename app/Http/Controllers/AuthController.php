<?php

namespace App\Http\Controllers;

use App\Models\User;
use Auth;
use F9Web\ApiResponseHelpers;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    use ApiResponseHelpers;

    public function login(): Response
    {
        $data = validator(request()->all(), [
            'email' => ['required', 'email', 'exists:users,email'],
            'password' => ['required'],
        ])->validated();

        $user = User::whereEmail($data['email'])->first();
        if (!Hash::check($data['password'], $user->getAuthPassword())) {
            return $this->apiResponse(
                ['errors' => ['password' => [trans('auth.failed')]]],
                Response::HTTP_UNPROCESSABLE_ENTITY,
            );
        }

        return $this->apiResponse([
            'token' => $user->createToken(time())->plainTextToken,
        ]);
    }

    public function logout(): Response
    {
        Auth::user()->currentAccessToken()->delete();

        return $this->respondOk('Successful logout');
    }
}
