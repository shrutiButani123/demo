@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="text-center">User Dashboard</h3>
    
    <div class="card mt-4">
        <div class="card-body">
            <h5 class="card-title">Your Quiz Performance</h5>
            <button type="submit" class="btn btn-primary w-100">
                <a href="{{ route('user.questions') }}" class="btn btn-primary w-100">Take Quiz</a>
            </button>
            <p><strong>Total Questions Attempted:</strong> {{ $total_attempts }}</p>
            <p><strong>Correct Answers:</strong> {{ $correct_answers }}</p>
            <p><strong>Wrong Answers:</strong> {{ $total_attempts - $correct_answers }}</p>
        </div>
    </div>

    <div class="mt-4">
        <h4>Your Answered Questions</h4>
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Question</th>
                    <th>Your Answer</th>
                    <th>Correct Answer</th>
                    <th>Result</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($answers as $answer)
                <tr>
                    <td>{{ $answer->question->question }}</td>
                    <td>{{ strtoupper($answer->selected_option) }}</td>
                    <td>{{ strtoupper($answer->question->correct_option) }}</td>
                    <td>
                        @if ($answer->selected_option == $answer->question->correct_option)
                            <span class="badge bg-success">Correct</span>
                        @else
                            <span class="badge bg-danger">Wrong</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
