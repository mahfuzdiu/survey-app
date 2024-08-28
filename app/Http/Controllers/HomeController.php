<?php

namespace App\Http\Controllers;

use App\Option;
use App\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    public function welcome(Request $request)
    {
        $question = Question::with('options')->where('is_active', true)->first();
        return view('welcome', ['question' => $question]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $questions = Question::orderBy('id', 'desc')->get();
        return view('home', ['questions' => $questions]);
    }

    public function store(Request $request)
    {

    }

    public function calculateVotePercentage($question)
    {
        $totalVote = 0;
        $votes = [];
        foreach ($question->options as $option){
            $totalVote = $totalVote + $option->vote_count;
        }

        if($totalVote != 0){
            $sumOfIntResult = 0;
            foreach ($question->options as $key => $option) {
                $votePercent = $totalVote ? number_format((100 * $option->vote_count) / $totalVote, 5) : '0.0';
                $value = explode('.', $votePercent);
                $votes[$value[1]] = $value[0];
                $sumOfIntResult = $sumOfIntResult + $value[0];
            }

            $lackBehindPercentValue = 100 - $sumOfIntResult;
            $originalVotes = $votes;

            krsort($votes);
            foreach ($votes as $key => $value){
                if($lackBehindPercentValue == 0)
                    break;
                $originalVotes[$key]++;
                $lackBehindPercentValue--;

            }

            $originalVotes = array_values($originalVotes);
            foreach ($question->options as $key => $option){
                $option->vote_count = $originalVotes[$key];
            }
        }

        return $question;
    }
}
