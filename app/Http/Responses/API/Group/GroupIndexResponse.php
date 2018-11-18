<?php

namespace App\Http\Responses\API\Group;

use App\Http\Responses\API\Response;
use App\Http\Resources\GroupCollection;

class GroupIndexResponse extends Response
{
    public $groups;

    /**
     * groupIndexResponse constructor.
     *
     * @param $groups
     */
    public function __construct($groups)
    {
        $this->groups = $groups;
    }

    /**
     * Create an HTTP response that represents the object.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function toResponse($request)
    {
        return (new GroupCollection($this->groups))->toResponse($request);
    }
}