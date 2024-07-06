<?php

namespace App\Http\Controllers;

use App\Models\Donor;
use Illuminate\Http\Request;

class AdminDonorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $donors=Donor::latest()->get();

        return view('admin.donors.index',compact('donors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $donor=null;

        return view('admin.donors.add_edit',compact('donor'));
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
            'name'=>'required|unique:donors,name',
            'image'=>'required|image',
        ]);

        $donor=Donor::create([
            'name'=>$request->name,
            'image_path'=>$request->file('image')->store('donors'),
        ]);

        return redirect()->route('admin.donors.index')->withToastSuccess('Donor added successfully!');
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
        $donor=Donor::findOrFail($id);

        return view('admin.donors.add_edit',compact('donor'));
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
        $donor=Donor::findOrFail($id);

        $request->validate([
            'name'=>'required|unique:donors,name,'.$donor->id,
            'image'=>'nullable|image',
        ]);

        $donor->update([
            'name'=>$request->name,
        ]);

        if($request->hasFile('image')){
            $donor->update([
                'image_path'=>$request->file('image')->store('donors'),
            ]);
        }

        return redirect()->route('admin.donors.index')->withToastSuccess('Donor updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Donor::findOrFail($id)->delete();

        return redirect()->route('admin.donors.index')->withToastSuccess('Donor deleted successfully!');
    }
}
