<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\ContactUsUser;
use App\Models\Document;
use App\Models\Donor;
use App\Models\FeedbackQuestion;
use App\Models\Testimonial;
use App\Models\UserFeedback;
use Illuminate\Http\Request;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\PhpWord;

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
        $documents = Document::latest()->take(4)->get();

        $blogs = Blog::latest()->take(4)->get();

        // $donors = Donor::latest()->get();

        $testimonials=Testimonial::latest()->get();

        $feedbackQuestions=FeedbackQuestion::with('choices')->get();

        return view('landing', compact('documents', 'blogs', 'testimonials','feedbackQuestions'));
    }

    public function download($id)
    {


        $document = Document::findOrFail($id);

        $adminDocController = new AdminDocumentController();

        $htmlContent = $adminDocController->convertDocToHtml(storage_path('app/public/' . $document->file_path));


        // remove {MC_ST} words from the content


        $htmlContent = $adminDocController->sanitizeHtml($htmlContent);



                        // remove {D_ST} AND {D_EN} signs
        $htmlContent = $this->removeCustomTags($htmlContent);



        $phpWord = new PhpWord();
        $section = $phpWord->addSection();

        // Add HTML content to the section
        \PhpOffice\PhpWord\Shared\Html::addHtml($section, $htmlContent);



        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save(storage_path('app/public/' . basename($document->file_path, '.docx') . '_downloaded.docx'));

        return response()->download(storage_path('app/public/' . basename($document->file_path, '.docx') . '_downloaded.docx'), $document->title . '_downloaded.docx')->deleteFileAfterSend(true);

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

    public function feedbackSubmit(Request $request)
    {

        $questions=$request->questions;
        $comments=$request->comments;

        // dd($request->all());

        $sessionId=session()->getId().time().rand(1000,9999);

        foreach ($comments as $questionId=>$comment){

            UserFeedback::create([
                'user_id'=>auth()->id(),
                'feedback_question_id'=>$questionId,
                'feedback_question_choice_id'=>$questions[$questionId] ?? null,
                'comment'=>$comment,
                'session_id'=>$sessionId
            ]);
        }

        return redirect()->back()->withToastSuccess('Your feedback has been submitted successfully!');
    }
}

