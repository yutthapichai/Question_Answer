<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Question;
use Illuminate\Http\Request;

class AnswersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store(Question $question, Request $request)
    {
        /* $request->validate([
            'body' => 'required'
        ]);
        $question->answers()->create(['body' => $request->body, 'user_id' => \Auth::id()]);
        */

        $question->answers()
            ->create($request->validate(['body' => 'required']) + ['user_id' => \Auth::id()]); // at model answer will add increment +1

        return back()->with('success', 'Your answer has been submitted successfully');
    }

    public function show(Answer $answer)
    {
        //
    }

    public function edit(Question $question, Answer $answer)
    {
        $this->authorize('update', $answer); //policy check auth on function update

        return view('answers.edit', compact('question', 'answer'));
    }

    public function update(Request $request, Question $question, Answer $answer)
    {
        $this->authorize('update', $answer); //policy check auth on function update
        $answer->update($request->validate([
            'body' => 'required'
        ]));

        return redirect()->route('questions.show', $question->slug)->with('success', 'You have been updated');
    }

    public function destroy(Question $question, Answer $answer)
    {
        $this->authorize('delete', $answer);

        $answer->delete();

        return redirect()->route('questions.show', $question->slug)->with('success', 'Your answer has been deleted successfully');
    }
}
