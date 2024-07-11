<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\ContactUsUser;
use App\Models\Document;
use App\Models\Donor;
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

        $donors=Donor::latest()->get();

        return view('landing',compact('documents','blogs','donors'));
    }

    public function download($id){

        $document = Document::findOrFail($id);


        return response()->download(storage_path('app/public/' . $document->file_path), $document->title . '.docx');
    }

    public function contactSubmit(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'type' => 'required|in:complaint,request',
            'message' => 'required',
        ]);

        ContactUsUser::create([
            'name' => $request->name,
            'email' => $request->email,
            'type' => $request->type,
            'message' => $request->message,
        ]);


        return redirect()->back()->withToastSuccess('Your message has been submitted successfully!');
    }
}
