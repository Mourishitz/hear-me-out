<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends Controller
{
    public function register(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $user = User::query()->create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
        ]);

        $token = JWTAuth::fromUser($user);

        return response()->json(compact('user', 'token'), 201);
    }

    public function index(): UserResource
    {
        return UserResource::collection(User::query()->paginate());
    }

    public function show(int $id): UserResource|JsonResponse
    {
        $user = User::query()->find($id);

        if (! $user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        return new UserResource($user);
    }

    public function getFollowing(?int $id = null)
    {
        $user = $id ? User::query()->find($id) : JWTAuth::parseToken()->authenticate();

        if (! $user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        return $user->following;
    }

    public function getFollowers(?int $id = null)
    {
        $user = $id ? User::query()->find($id) : JWTAuth::parseToken()->authenticate();

        if (! $user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        return $user->followers;
    }

    public function follow(Request $request, int $id): JsonResponse
    {
        $user = User::query()->find($id);

        if (! $user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $authUser = JWTAuth::parseToken()->authenticate();

        if ($authUser->isFollowing($user)) {
            return response()->json(['message' => 'Already following this user'], 400);
        }

        $authUser->follow($user);

        return response()->json(['message' => 'Successfully followed user'], 200);
    }

    public function unfollow(Request $request, int $id): JsonResponse
    {
        $user = User::query()->find($id);

        if (! $user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $authUser = JWTAuth::parseToken()->authenticate();

        if (! $authUser->isFollowing($user)) {
            return response()->json(['message' => 'Not following this user'], 400);
        }

        $authUser->unfollow($user);

        return response()->json(['message' => 'Successfully unfollowed user'], 200);
    }

    public function setSpotify(Request $request, int $id): JsonResponse
    {
        return response()->json(['message' => 'Not implemented'], 501);
    }
}
