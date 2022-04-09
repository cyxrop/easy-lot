<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Resources\UserResource;
use Auth;
use Hash;
use Illuminate\Http\Resources\Json\JsonResource;

class UserController extends Controller
{
    public function store(UserRequest $request): JsonResource
    {
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);

        return new UserResource(User::create($data));
    }

    public function current(): JsonResource
    {
        return new UserResource(Auth::user());
    }
}
