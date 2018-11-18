<?php

namespace App\Http\Controllers\API;

use App\Models\Group;

use App\Http\Requests\API\Group\IndexGroups;
use App\Http\Requests\API\Group\StoreGroup;
use App\Http\Requests\API\Group\UpdateGroup;

use App\Http\Responses\API\Group\GroupIndexResponse;
use App\Http\Responses\API\Group\GroupStoredResponse;
use App\Http\Responses\API\Group\GroupShowResponse;
use App\Http\Responses\API\Group\GroupUpdatedResponse;
use App\Http\Responses\API\Group\GroupDeletedResponse;

use App\Http\Controllers\Controller;

class GroupController extends Controller
{
    /**
     * GroupController constructor.
     *
     */
    public function __construct()
    {
        $this->authorizeResource(Group::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @param \App\Http\Requests\API\Group\IndexGroups $request
     * @return \App\Http\Responses\API\Group\GroupIndexResponse
     */
    public function index(IndexGroups $request)
    {
        $key_name = with(new Group)->getKeyName();
        $groups_query = Group::with(['users'])->orderBy($key_name);
        ['query' => $search_query, 'per_page' => $per_page] = $request;

        if (!empty($search_query)) {
            $groups_query = $groups_query->where(function ($query) use ($search_query) {
                $query->where('name', 'ilike', "%{$search_query}%");
            });
        }

        $groups = $groups_query->paginate($per_page);

        return new GroupIndexResponse($groups);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\API\Group\StoreGroup $request
     * @return \App\Http\Responses\API\Group\GroupStoredResponse
     */
    public function store(StoreGroup $request)
    {
        $group = Group::create($request->validated());

        return new GroupStoredResponse($group);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Group $group
     * @return \App\Http\Responses\API\Group\GroupShowResponse
     */
    public function show(Group $group)
    {
        return new GroupShowResponse($group->load('users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\API\Group\UpdateGroup $request
     * @param \App\Models\Group $group
     * @return \App\Http\Responses\API\Group\GroupUpdatedResponse
     */
    public function update(UpdateGroup $request, Group $group)
    {
        $group->update($request->validated());

        return new GroupUpdatedResponse($group);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Group $group
     * @return \App\Http\Responses\API\Group\GroupDeletedResponse
     * @throws \Exception
     */
    public function destroy(Group $group)
    {
        $group->delete();

        return new GroupDeletedResponse();
    }
}
