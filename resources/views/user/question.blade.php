@extends('layouts.app')

@section('content')
<h3 class="text-center">Quiz</h3>
<form method="POST" action="{{ route('user.questions.submit') }}">
    @csrf
    @foreach ($questions as $question)
        <div class="mb-4">
            <h5>{{ $question->question }}</h5>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="answers[{{ $question->id }}]" value="a" required>
                <label class="form-check-label">{{ $question->option_a }}</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="answers[{{ $question->id }}]" value="b">
                <label class="form-check-label">{{ $question->option_b }}</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="answers[{{ $question->id }}]" value="c">
                <label class="form-check-label">{{ $question->option_c }}</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="answers[{{ $question->id }}]" value="d">
                <label class="form-check-label">{{ $question->option_d }}</label>
            </div>
        </div>
    @endforeach
    <button type="submit" class="btn btn-primary w-100">Submit</button>
</form>
@endsection
