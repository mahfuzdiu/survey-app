<?php

namespace App\Http\Controllers;

use App\Option;
use App\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     *
     */
    public function index()
    {
        $questions = Question::orderBy('id', 'desc')->get();
        return view('questions', ['questions' => $questions]);
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
    public function store(Request $request)
    {
        $this->validate($request, [
            'question' => 'required',
            'options' => 'required',
        ]);

        DB::transaction(function () use ($request) {
            $question = Question::create([
                'question' => $request->question,
                'slug' => $this->generateSlug($request->question),
            ]);

            $options = [];

            foreach ($request->options as $option) {
                $options[] = [
                    'question_id' => $question->id,
                    'option' => $option
                ];
            }
            Option::insert($options);
        });
        return response()->redirectTo(route('questions.index'))->with(['$questions' => Question::with('options')->get()]);
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
        $question = Question::with('options')->find($id);
        return view('question-edit', ['question' => $question]);
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
        $this->validate($request, [
            'question' => 'required',
            'options' => 'required',
        ]);

        $question = Question::find($id);
        $question->update(['question' => $request->get('question')]);

        foreach ($request->options as $key => $option) {
            $item = Option::find($key);
            $item->update(['option' => $option]);
        }

        return redirect()->route('questions.edit', ['question' => $question]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $question = Question::find($id);
        $question->delete($id);
        return redirect()->route('questions.index');
    }

    private function generateSlug($question): string
    {
        $questionArray = explode(" ", strtolower($question));
        return implode('-', $questionArray);
    }

    public function updateQuestionStatus($questionId)
    {
        $question = Question::find($questionId);
        $question->update(['is_active' => !$question->is_active]);

        if($activeQuestion = Question::where('is_active', true)->where('id', '!=', $questionId)->first()){
            $activeQuestion->update(['is_active' => false]);
        }

        return redirect()->route('questions.index');
    }

    public function submitPublicVote(Request $request)
    {
        $this->validate($request, [
            'option_id' => 'required'
        ]);

        $option = Option::find($request->get('option_id'));
        $option->vote_count = $option->vote_count + 1;
        $option->update();

        Cookie::queue('voted', true, 24 * 60);
        return redirect()->route('welcome');
    }

    public function watchGraph(HomeController $homeController, $id)
    {
        $question = Question::with('options')->find($id);
        $question = $homeController->calculateVotePercentage($question);
        return view('graph', ['question' => $question]);
    }
}
