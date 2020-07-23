<?php

namespace App\Http\Controllers;
use App\Question;
use App\Answer;
use Illuminate\Http\Request;

class VotesController extends Controller
{
    public function voteQuestion(Question $question, int $vote) {
        //Either I need to update the vote or need to create the vote again
        if(auth()->user()->hasVoteForQuestion($question)) {
            dd("hi");
            $question->updateVote($vote);
        }
        else {
            $question->vote($vote);
        }
        return redirect()->back();
    }
    public function voteAnswer(Answer $answer, int $vote) {
        if(auth()->user()->hasVoteForAnswer($answer)) {
            $answer->updateVote($vote);
        }
        else {
            $answer->vote($vote);
        }
        return redirect()->back();
    }
}
