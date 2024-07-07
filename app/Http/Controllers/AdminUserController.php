<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users=User::latest()->get();

        return view('admin.users.index',compact('users'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user=User::findOrFail($id);

        $roles=\Spatie\Permission\Models\Role::all();

        return view('admin.users.add_edit',compact('user','roles'));
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
        $user=User::findOrFail($id);



        $request->validate([
            'name'=>'required',
            'email'=>'required|email|unique:users,email,'.$user->id,
            'role'=>'required|exists:roles,name',
            'verified'=>'nullable'
        ]);



        $user->update([
            'name'=>$request->name,
            'email'=>$request->email,
        ]);

        if($request->verified && !$user->email_verified_at){
            $user->email_verified_at=now();
            $user->save();
        }

        if(!$request->verified && $user->email_verified_at){
            $user->email_verified_at=null;
            $user->save();
        }

        $user->syncRoles([$request->role]);

        return redirect()->route('admin.users.index')->withToastSuccess('User updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::findOrFail($id)->delete();

        return redirect()->route('admin.users.index')->withToastSuccess('User deleted successfully');
    }
}
