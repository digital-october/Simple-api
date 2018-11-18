<?php

namespace App\Http\Responses\API\User;

use App\Models\User;
use App\Http\Responses\API\Response;
use App\Http\Resources\User as UserResource;

class UserStoredResponse extends Response
{
    public $user;

    /**
     * UserStoredResponse constructor.
     *
     * @param \App\Models\User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Create an HTTP response that represents the object.
     *
     * @param \Illuminate\Http\Request $request
     * @return \App\Http\Resources\User|\Illuminate\Http\Response
     */
    public function toResponse($request)
    {
        return new UserResource($this->user);
    }
}