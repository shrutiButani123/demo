@extends('layouts.admin-app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <h3 class="text-center">Create Question</h3>
        <form method="POST" action="{{ route('admin.questions.store') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">Question</label>
                <input type="text" name="question" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Option A</label>
                <input type="text" name="option_a" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Option B</label>
                <input type="text" name="option_b" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Option C</label>
                <input type="text" name="option_c" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Option D</label>
                <input type="text" name="option_d" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Correct Option</label>
                <select name="correct_option" class="form-select">
                    <option value="a">A</option>
                    <option value="b">B</option>
                    <option value="c">C</option>
                    <option value="d">D</option>
                </select>
            </div>
            <button type="submit" class="btn btn-success w-100">Save Question</button>
        </form>
    </div>
</div>
@endsection
