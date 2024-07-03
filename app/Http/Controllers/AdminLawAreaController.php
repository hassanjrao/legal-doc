<?php

namespace App\Http\Controllers;

use App\Models\LawArea;
use Illuminate\Http\Request;

class AdminLawAreaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lawAreas = LawArea::latest()->get();

        return view('admin.law-areas.index', compact('lawAreas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $lawArea=null;

        return view('admin.law-areas.add_edit',compact('lawArea'));
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
            'name' => 'required|unique:law_areas,name',
        ]);

        LawArea::create([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.law-areas.index')->withToastSuccess('Law Area created successfully!');
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
        $lawArea = LawArea::findOrFail($id);

        return view('admin.law-areas.add_edit',compact('lawArea'));
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
        $lawArea = LawArea::findOrFail($id);

        $request->validate([
            'name' => 'required|unique:law_areas,name,'.$lawArea->id,
        ]);

        $lawArea->update([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.law-areas.index')->withToastSuccess('Law Area updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        LawArea::findOrFail($id)->delete();

        return redirect()->route('admin.law-areas.index')->withToastSuccess('Law Area deleted successfully!');
    }
}
