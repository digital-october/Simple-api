<?php

namespace App\Http\Responses\API\User;

use App\Http\Responses\API\Response;
use App\Http\Resources\UserCollection;

class UserIndexResponse extends Response
{
    public $users;

    /**
     * UserIndexResponse constructor.
     *
     * @param $users
     */
    public function __construct($users)
    {
        $this->users = $users;
    }

    /**
     * Create an HTTP response that represents the object.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function toResponse($request)
    {
        return (new UserCollection($this->users))->toResponse($request);
    }
}