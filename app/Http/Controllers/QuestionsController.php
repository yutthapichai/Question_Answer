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

    public function index()
    {
        // \DB::enableQueryLog();
        $questions = Question::with('user')->latest()->paginate(10);
        return view('questions.index', compact('questions'));

        // dd(\DB::getQueryLog());
    }

    public function create()
    {

        // $question = new Question();
        // return view('questions.create', compact('question'));
        return view('questions.create')->with('question', new Question());
    }

    public function store(AskQuestionRequest $request)
    {
        $request->user()->questions()->create($request->only('title','body'));
        return redirect()->route('questions.index')->with('success', "your question has been submitted");
    }

    public function show(Question $question)
    {
        // $question->increment('views'); // or down
        $question->views = $question->views + 1;
        $question->save();
        return view('questions.show', compact('question'));
    }

    public function edit(Question $question)
    {
        // if(Gate::denies('update-question', $question)){ // check auth first will can edit or denies to allows
        //    abort(403, 'Access denied');
        // }
        $this->authorize("update", $question);
        return view('Questions.edit', compact('question'));
    }

    public function update(AskQuestionRequest $request, Question $question)
    {
        // if(Gate::denies('update-question', $question)){ // check auth first will can edit or denies to allows
        //    abort(403, 'Access denied');
        // }
        $this->authorize("update", $question);
        $question->update($request->only('title'. 'body'));
        return redirect('/questions')->with('success', "your question has been Update");
    }

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
