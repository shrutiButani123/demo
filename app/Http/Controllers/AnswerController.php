<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnswerController extends Controller
{
    public function index() {
        $questions = Question::all();
        return view('user.question', compact('questions'));
    }

    public function submit(Request $request) {
        // dd($request->all());

        // $question = Question::find($request->question_id);
        // $is_correct = $question->correct_option === $request->selected_option;

        // Answer::create([
        //     'user_id' => Auth::id(),
        //     'question_id' => $request->question_id,
        //     'selected_option' => $request->selected_option,
        //     'is_correct' => $is_correct
        // ]);

        // return redirect()->back()->with('success', 'Answer submitted!');


        $request->validate([
            'answers' => 'required|array',
            'answers.*' => 'in:a,b,c,d', // Ensure all answers are valid options
        ]);
    
        foreach ($request->answers as $question_id => $selected_option) {
            $question = Question::find($question_id);
            // dd($question->correct_option);
            // if (!$question) {
            //     continue; // Skip invalid question IDs
            // }
    
            if (!$question || $question->correct_option === null) {
                \Log::error("Question ID {$question_id} has no correct_option set.");
                continue; // Skip invalid or incomplete questions
            }
        
            $is_correct = ($question->correct_option === $selected_option) ? 1 : 0;
            \Log::info("Question ID {$question_id}, Selected: {$selected_option}, Correct: {$question->correct_option}, is_correct: {$is_correct}");
  
            $answer = Answer::create([
                'user_id' => Auth::id(),
                'question_id' => $question_id,
                'selected_option' => $selected_option,
                'is_correct' => $is_correct
            ]);

            
        }
    
        return redirect()->route('user.dashboard')->with('success', 'Quiz submitted successfully!');
    }
}
