<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Answer;

class UserLoginController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $answers = Answer::where('user_id', $user->id)->with('question')->get();
        $total_attempts = $answers->count();
        $correct_answers = $answers->where('is_correct', 1)->count();

        return view('user.dashboard', compact('user', 'answers','total_attempts', 'correct_answers'));
    }
}
