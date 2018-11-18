<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Answer;

class AcceptAnswerController extends Controller
{
    public function __invoke(Answer $answer) // answer had send from view
    {
        $this->authorize('accept', $answer); // function accept policy

        $answer->question->acceptBestAnswer($answer);

        return back();
    }
}
