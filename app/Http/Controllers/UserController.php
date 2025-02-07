<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

use App\Http\Resources\UserResource;

class UserController extends Controller
{
    /**
     * Requires endpoints, aside from those excepted, to use authentication
     */
    public function __construct()
    {
        $this->middleware('auth:api')
        ->except([
            'index', 
            'show', 
        ]);
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
            UserResource::collection(User::paginate(10))
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
        $client = $request->user();

        if ($client->cannot('create_user')) {
            return response()->json([
                'error' => 'Forbidden',
            ], 403);
        }

        $user = User::create([
            'user_name' => $request->user_name,
            'password' => $request->password,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'birth_date' => $request->birth_date,
            'email' => $request->email,
            'ad_sense_snippet' => $request->ad_sense_snippet,
        ]);

        $user->roles()->attach(\App\Role::where('name', 'User')->first()->id);

        return $this->jsonResponse(new UserResource($user));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return $this->jsonResponse(new UserResource($user));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $client = $request->user();

        if ($client->cannot('edit_user')
        && $client->id != $user->id) {
            return response()->json([
                'error' => 'Forbidden',
            ], 403);
        }

        $restricted = [
            'add_roles',
            'remove_roles',
            'is_confirmed',
            'exp',
            'level',
        ];

        if ($request->has($restricted)
        && $client->cannot('edit_user')) {
            return response()->json([
                'error' => 'Forbidden',
            ], 403);
        }

        if ($request->has(['add_roles'])) {
            $user->roles()->syncWithoutDetaching($request->add_roles);
        }

        if ($request->has(['remove_roles'])) {
            $user->roles()->detach($request->remove_roles);
        }

        $user->update($request->only([
            'user_name',
            'password',
            'first_name',
            'last_name',
            'birth_date',
            'email',
            'is_confirmed',
            'exp',
            'level',
            'ad_sense_snippet',
        ]));

        return $this->jsonResponse(new UserResource($user));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, User $user)
    {
        $client = $request->user();

        if ($client->cannot('delete_user')) {
            return response()->json([
                'error' => 'Forbidden',
            ], 403);
        }

        $user->delete();

        return response()->json(null, 204);
    }
}
