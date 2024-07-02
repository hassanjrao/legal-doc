<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Document;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $documents=Document::latest()->take(4)->get();

        $blogs=Blog::latest()->take(4)->get();

        return view('landing',compact('documents','blogs'));
    }

    public function download($id){

        $document = Document::findOrFail($id);

        return response()->download(storage_path('app/public/' . $document->file_path));
    }
}
