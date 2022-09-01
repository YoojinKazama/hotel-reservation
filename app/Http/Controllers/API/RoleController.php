<?php

namespace App\Http\Controllers\API;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return Role::with('user', 'created_by_user')->get();
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
            'title' => 'required'
        ]);

        return Role::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Role::with('user', 'created_by_user')->find($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $Role = Role::find($id);
        $Role->update($request->all());

        return $Role;
    }

    public function restore(Role $Role, $id)
    {
        //
        $Role = Role::onlyTrashed()->where('id', $id)->restore();
        return Role::find($id);
    }

    public function destroy(Role $Role, $id)
    {
        //if the model soft deleted
        $Role = Role::find($id);

        $Role->delete();
        return $Role;
    }

    public function show_soft_deleted($all)
    {
        $Role = Role::onlyTrashed()->get();

        return $Role;
    }

    public function search($title)
    {

        return Role::where('title', 'like', '%'.$title.'%')->get();
    }

}
