<?php

namespace App\Http\Controllers;

use App\Role;
use Illuminate\Http\Request;

use App\Http\Resources\RoleResource;

class RoleController extends Controller
{
    /**
     * Requires endpoints to use authentication
     */
    public function __construct()
    {
        $this->middleware('auth:api')
        ->except([
            'index', 
            'show', 
        ]);;
    }

    /**
     * Convert payload to json
     * 
     * @param Mixed $payload data that can be converted to a json object
     * @return \Illuminate\Http\Response a json response
     */
    private function jsonResponse($payload)
    {
        return response()->json($payload);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->jsonResponse(
            RoleResource::collection(Role::with('users')->paginate(10))
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $role = Role::create([
            'name' => $request->name,
            'create_comment' => $request->create_comment,
            'create_article' => $request->create_article,
            'create_role' => $request->create_role,
            'create_user' => $request->create_user,
            'edit_comment' => $request->edit_comment,
            'edit_article' => $request->edit_article,
            'edit_role' => $request->edit_role,
            'edit_user' => $request->edit_user,
            'delete_comment' => $request->delete_comment,
            'delete_article' => $request->delete_article,
            'delete_role' => $request->delete_role,
            'delete_user' => $request->delete_user,
            'invite_author' => $request->invite_author,
            'revoke_author' => $request->revoke_author,
            'schedule_article' => $request->schedule_article,
            'run_article' => $request->run_article,
            'view_pending' => $request->view_pending,
            'permalink' => $request->permalink,
        ]);

        return $this->jsonResponse(new RoleResource($role));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        return $this->jsonResponse(new RoleResource($role));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        $role->update($request->only([
            'name',
            'create_comment',
            'create_article',
            'create_role',
            'create_user',
            'edit_comment',
            'edit_article',
            'edit_role',
            'edit_user',
            'delete_comment',
            'delete_article',
            'delete_role',
            'delete_user',
            'invite_author',
            'revoke_author',
            'schedule_article',
            'run_article',
            'view_pending',
            'permalink',
        ]));

        if ($request->has(['add_users'])) {
            $role->users()->syncWithoutDetaching($request->add_users);
        }

        if ($request->has(['remove_users'])) {
            $role->users()->detach($request->remove_users);
        }

        return $this->jsonResponse(new RoleResource($role));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        $role->delete();

        return response()->json(null, 204);
    }
}
