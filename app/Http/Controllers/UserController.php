<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Resources\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function store(UserRequest $request): JsonResource
    {
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);

        return new UserResource(User::create($data));
    }
}
