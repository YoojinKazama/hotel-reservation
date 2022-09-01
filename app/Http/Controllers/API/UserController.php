<?php

// Default
namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use DataTables;

class UserController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){

        return User::all();
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function datatable(){
        
        $data = User::all();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->rawColumns(['action'])
                    ->make(true);
    }
    
    public function create()
    {
        //

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
            'title' => 'required',
        ]);

        return User::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return User::find($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return User::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $user->update($request->all());

        return $user;
    }


    public function restore(User $user, $id)
    {
        //
        $requirements_bin = User::onlyTrashed()->where('id', $id)->restore();
        return User::find($id);
    }

    public function destroy(User $user, $id)
    {
        //if the model soft deleted
        $user = User::find($id);

        $user->delete();
        return $user;
    }


    public function show_soft_deleted($all)
    {
        $user = User::onlyTrashed()->get();

        return $user;
    }

    public function search($title)
    {

        return User::where('email', 'like', '%'.$title.'%')->get();
    }

    public function get_faculty_for_required_list($role_id)
    {
        $faculty_list = User::join("faculties", "faculties.user_id", "=", "users.id")
        ->join("user_roles", "user_roles.user_id", "=", "users.id")
        ->where('user_roles.role_id', $role_id)
        ->get('users.*', 'faculties.id');

        return $faculty_list;
    }
}
