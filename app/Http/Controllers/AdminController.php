<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use App\Models\Question;

class AdminController extends Controller
{
    public function showLoginForm() {
        return view('admin.login');
    }
    
    public function login(Request $request) {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors(['email' => 'Invalid credentials']);
    }

    public function dashboard()
    {
        $questions = Question::get();
        $users = User::with(['answers'])->get();
        return view('admin.dashboard', compact('questions', 'users'));
    }

    // public function userDetails($id)
    // {
    //     $user = User::with(['attempts.question'])->findOrFail($id);
    //     return view('admin.userDetails', compact('user'));
    // }
}
