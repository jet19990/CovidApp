<?php

namespace App\Http\Controllers;

use App\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Role::all();
    }

    public function store($uid){
        
    }

   

    public function update(Request $request, $uid)
    {
        // validation
        $this->validate($request, [
           'role' => 'required'
        ]);

        $role = Role::where('uid', $uid)->first();

        $role->role = $request->role;

        if($role->save()){
            return response()->json([
                'status' => true,
                'message' => 'Role updated successfully !'
            ]);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        //
    }
}
