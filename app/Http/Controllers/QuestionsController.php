<?php

namespace App\Http\Controllers;

use App\Question;
use App\Http\Requests\AskQuestionRequest;
use Illuminate\Support\Facades\Gate;

class QuestionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // \DB::enableQueryLog();
        $questions = Question::with('user')->latest()->paginate(10);
        return view('questions.index', compact('questions'));

        // dd(\DB::getQueryLog());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        // $question = new Question();
        // return view('questions.create', compact('question'));
        return view('questions.create')->with('question', new Question());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AskQuestionRequest $request)
    {
        $request->user()->questions()->create($request->only('title','body'));
        return redirect()->route('questions.index')->with('success', "your question has been submitted");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question)
    {
        // $question->increment('views'); // or down
        $question->views = $question->views + 1;
        $question->save();
        return view('questions.show', compact('question'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function edit(Question $question)
    {
        // if(Gate::denies('update-question', $question)){ // check auth first will can edit or denies to allows
        //    abort(403, 'Access denied');
        // }
        $this->authorize("update", $question);
        return view('Questions.edit', compact('question'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function update(AskQuestionRequest $request, Question $question)
    {
        // if(Gate::denies('update-question', $question)){ // check auth first will can edit or denies to allows
        //    abort(403, 'Access denied');
        // }
        $this->authorize("update", $question);
        $question->update($request->only('title'. 'body'));
        return redirect('/questions')->with('success', "your question has been Update");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question)
    {
        // if(Gate::denies('delete-question', $question)){ // check auth first will can edit or denies to allows
        //    abort(403, 'Access denied');
        // }
        $this->authorize("delete", $question);
        $question->delete();
        return redirect('/questions')->with('success', "your question has been Delete");
    }
}
