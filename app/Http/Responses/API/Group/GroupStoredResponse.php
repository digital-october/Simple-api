<?php

namespace App\Http\Responses\API\Group;

use App\Models\group;
use App\Http\Responses\API\Response;
use App\Http\Resources\Group as GroupResource;

class GroupStoredResponse extends Response
{
    public $group;

    /**
     * GroupStoredResponse constructor.
     *
     * @param \App\Models\group $group
     */
    public function __construct(Group $group)
    {
        $this->group = $group;
    }

    /**
     * Create an HTTP response that represents the object.
     *
     * @param \Illuminate\Http\Request $request
     * @return \App\Http\Resources\Group|\Illuminate\Http\Response
     */
    public function toResponse($request)
    {
        return new GroupResource($this->group);
    }
}