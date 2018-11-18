<?php

namespace App\Http\Responses\API\Role;

use App\Http\Responses\API\Response;
use App\Http\Resources\RoleCollection;

class RoleIndexResponse extends Response
{
    public $roles;

    /**
     * RoleIndexResponse constructor.
     *
     * @param $roles
     */
    public function __construct($roles)
    {
        $this->roles = $roles;
    }

    /**
     * Create an HTTP response that represents the object.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function toResponse($request)
    {
        return (new RoleCollection($this->roles))->toResponse($request);
    }
}