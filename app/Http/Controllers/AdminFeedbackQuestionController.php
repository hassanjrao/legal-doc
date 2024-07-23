<?php

namespace App\Http\Controllers;

use App\Models\FeedbackQuestion;
use Illuminate\Http\Request;

class AdminFeedbackQuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $feedbackQuestions = FeedbackQuestion::latest()
            ->with('choices')
            ->get();
        return view('admin.feedback-questions.index', compact('feedbackQuestions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $feedbackQuestion = null;

        return view('admin.feedback-questions.add_edit', compact('feedbackQuestion'));
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
            'question' => 'required',
            'options' => 'required|array|min:2',
        ]);

        $feedbackQuestion = FeedbackQuestion::create([
            'question' => $request->question,
        ]);

        foreach ($request->options as $option) {
            $feedbackQuestion->choices()->create([
                'choice' => $option,
            ]);
        }

        return redirect()->route('admin.feedback-questions.index')->withToastSuccess('Feedback Question added successfully');
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
        $feedbackQuestion = FeedbackQuestion::with('choices')->findorfail($id);

        return view('admin.feedback-questions.add_edit', compact('feedbackQuestion'));
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
        $feedbackQuestion = FeedbackQuestion::findorfail($id);

        $request->validate([
            'question' => 'required',
            'options' => 'required|array|min:2',
        ]);

        $feedbackQuestion->update([
            'question' => $request->question,
        ]);

        $feedbackQuestion->choices()->delete();

        foreach ($request->options as $option) {
            $feedbackQuestion->choices()->create([
                'choice' => $option,
            ]);
        }

        return redirect()->route('admin.feedback-questions.index')->withToastSuccess('Feedback Question updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $feedbackQuestion = FeedbackQuestion::findorfail($id);

        $feedbackQuestion->choices()->delete();

        $feedbackQuestion->delete();


        return redirect()->route('admin.feedback-questions.index')->withToastSuccess('Feedback Question deleted successfully');
    }
}
