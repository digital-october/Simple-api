<?php

namespace App\Http\Responses\API\Group;

use App\Models\Group;
use App\Http\Responses\API\Response;
use App\Http\Resources\Group as GroupResource;

class GroupShowResponse extends Response
{
    public $group;

    /**
     * GroupShowResponse constructor.
     *
     * @param \App\Models\Group $group
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