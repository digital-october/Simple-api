<?php

namespace App\Http\Responses\API\Auth;

use App\Http\Responses\API\Response;

class RegisteredResponse extends Response
{
    /**
     * Create an HTTP response that represents the object.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Http\Response
     */
    public function toResponse($request)
    {
        return ['message' => 'Registration successful.'];
    }
}
