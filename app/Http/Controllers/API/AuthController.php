<?php

namespace App\Http\Controllers\API;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Models\User;
use App\Models\Role;

use App\Http\Resources\User as UserResource;

use App\Http\Requests\API\Auth\Register;

use App\Http\Responses\API\Auth\RegisteredResponse;

use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * @param \App\Http\Requests\API\Auth\Register $request
     * @return \App\Http\Responses\API\Auth\RegisteredResponse
     */
    public function register(Register $request)
    {
        $user_data = $request->validated();
        $user_data['password'] = Hash::make($request->password);

        $user = new User($user_data);
        $client_role = Role::client()->first();

        $user->role()->associate($client_role);
        $user->save();

        return new RegisteredResponse();
    }

    /**
     * Get the authenticated User.
     *
     * @return \App\Http\Resources\User
     */
    public function me()
    {
        return UserResource::make(Auth::user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
