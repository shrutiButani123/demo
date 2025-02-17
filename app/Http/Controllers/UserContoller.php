<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        // $answers = Attempt::where('user_id', $user->id)->with('question')->get();
        // $total_attempts = $answers->count();
        // $correct_answers = $answers->where('selected_option', 'correct_option')->count();

        return view('user.dashboard', compact('user'));
    }

//     public function viewMyResults()
//     {
//         $results = Attempt::where('user_id', Auth::id())->with('question')->get();
//         return response()->json($results);
//     }
}

