@extends('layouts.admin-app')

@section('content')
<div class="row">
    <div class="col-md-6">
        <h3>Admin Dashboard</h3>
        <a href="{{ route('admin.questions.create') }}" class="btn btn-primary">Add New Question</a>
    </div>
</div>

<div class="mt-4">
    <h4>All Questions</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Question</th>
                <th>Correct Answer</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($questions as $question)
                <tr>
                    <td>{{ $question->question }}</td>
                    <td>{{ strtoupper($question->correct_option) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div>
<h3 class="text-center">User Quiz Results</h3>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>#</th>
            <th>User</th>
            <th>Total Questions</th>
            <th>Correct Answers</th>
            <th>Wrong Answers</th>
            <th>Score (%)</th>
            <th>Details</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $index => $user)
            @php
                $total = $user->answers->count();
                $correct = $user->answers->where('is_correct', true)->count();
                $wrong = $total - $correct;
                $score = $total > 0 ? round(($correct / $total) * 100, 2) : 0;
            @endphp
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $total }}</td>
                <td class="text-success">{{ $correct }}</td>
                <td class="text-danger">{{ $wrong }}</td>
                <td><strong>{{ $score }}%</strong></td>
                {{--<td><a href="{{ route('admin.user.quiz.detail', $user->id) }}" class="btn btn-primary btn-sm">View</a></td>--}}
            </tr>
        @endforeach
    </tbody>
</table>
</div>
@endsection
