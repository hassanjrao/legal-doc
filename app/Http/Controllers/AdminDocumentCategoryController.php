<?php

namespace App\Http\Controllers;

use App\Models\DocumentCategory;
use Illuminate\Http\Request;

class AdminDocumentCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $documentCategories = DocumentCategory::latest()->get();

        return view('admin.document-categories.index', compact('documentCategories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $documentCategory=null;

        return view('admin.document-categories.add_edit',compact('documentCategory'));
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
            'name' => 'required|unique:document_categories,name',
        ]);

        DocumentCategory::create([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.document-categories.index')->withToastSuccess('Document Category created successfully!');
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
        $documentCategory = DocumentCategory::findOrFail($id);

        return view('admin.document-categories.add_edit', compact('documentCategory'));
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
        $documentCategory = DocumentCategory::findOrFail($id);

        $request->validate([
            'name' => 'required|unique:document_categories,name,' . $documentCategory->id,
        ]);

        $documentCategory->update([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.document-categories.index')->withToastSuccess('Document Category updated successfully!');


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DocumentCategory::findOrFail($id)->delete();

        return redirect()->route('admin.document-categories.index')->withToastSuccess('Document Category deleted successfully!');
    }
}
