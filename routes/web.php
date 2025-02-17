<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\AnswerController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserLoginController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);


Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/admin/login', [AdminController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth', 'admin:admin')->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
//     Route::get('/admin/user/{id}', [AdminController::class, 'userDetails'])->name('admin.userDetails');
    Route::get('admin/questions', [QuestionController::class, 'index'])->name('admin.questions');
    Route::get('admin/questions/create', [QuestionController::class, 'create'])->name('admin.questions.create');
    Route::post('admin/questions', [QuestionController::class, 'store'])->name('admin.questions.store');
});

// User Routes
Route::middleware('auth', 'admin:user')->group(function () {
    Route::get('/dashboard', [UserLoginController::class, 'dashboard'])->name('user.dashboard');
    Route::get('questions', [AnswerController::class, 'index'])->name('user.questions');
    Route::post('questions/submit', [AnswerController::class, 'submit'])->name('user.questions.submit');
});