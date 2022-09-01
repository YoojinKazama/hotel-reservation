<?php

namespace App\Http\Controllers\API;

use App\Models\UserRole;
use Illuminate\Http\Request;

class UserRoleController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /* Fetching w/o relationship */
        return UserRole::all();

        /* Fetching w/ relationship */
        // return UserRole::with('user', 'role')->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $request->validate([
            'user_id' => 'required',
            'role_id' => 'required',
        ]);

        return UserRole::create($request->all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'role_id' => 'required',
        ]);

        return UserRole::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UserRole  $userRole
     * @return \Illuminate\Http\Response
     */
    public function show(UserRole $userRole)
    {
        // Default
        // return UserRole::find($id);

        return UserRole::with('user', 'role')->find($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UserRole  $userRole
     * @return \Illuminate\Http\Response
     */
    public function edit(UserRole $userRole)
    {
        // Default
        // return UserRole::find($id);

        return UserRole::with('user', 'role')->find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UserRole  $userRole
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserRole $userRole)
    {
        $user_role = UserRole::find($id);
        $user_role->update($request->all());

        return $user_role;
    }

    public function restore(UserRole $user_role, $id)
    {
        //
        $role = UserRole::onlyTrashed()->where('id', $id)->restore();
        return UserRole::find($id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserRole  $userRole
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserRole $userRole)
    {
        //if the model soft deleted
        $user_role = UserRole::find($id);

        $user_role->delete();
        return $user_role;
    }

    public function search($title)
    {

        return UserRole::where('title', 'like', '%'.$title.'%')->get();
    }

    public function multi_insert(Request $request)
    {

        $data = $request->all();
        $user = UserRole::where('user_id', $data[0]['user_id'])->delete();

        for($i=0; $i < count($data); $i++) {
            UserRole::create($data[$i]);
        }

        return [
            'message' => 'Multiple Insert Success.'
        ];
        
    }
}
