<?php

namespace App\Http\Controllers\API;

use App\Models\Role;

use App\Http\Requests\API\Role\IndexRoles;
use App\Http\Responses\API\Role\RoleIndexResponse;

use App\Http\Controllers\Controller;

class RoleController extends Controller
{
    /**
     * RoleController constructor.
     *
     */
    public function __construct()
    {
        $this->authorizeResource(Role::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @param \App\Http\Requests\API\Role\IndexRoles $request
     *
     * @return \App\Http\Responses\API\Role\RoleIndexResponse
     */
    public function index(IndexRoles $request)
    {
        return new RoleIndexResponse(Role::all());
    }
}
