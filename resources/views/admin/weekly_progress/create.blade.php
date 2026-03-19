@extends('layouts.app')

@section('title', 'Add Weekly Progress')

@section('content')
<div class="container py-4 max-w-3xl">

    <h4 class="mb-4 fw-semibold">📈 Add Weekly Progress</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST"
          action="{{ route('admin.weekly-progress.store') }}"
          enctype="multipart/form-data">
        @csrf

        <!-- Student Enrollment -->
        <div class="mb-3">
            <label class="form-label fw-semibold">Student</label>
            <select name="enrollment_id" class="form-select" required>
                <option value="">— Select Student —</option>

                @foreach($enrollments as $enrollment)
                    <option value="{{ $enrollment->id }}">
                        {{ $enrollment->user->name }}
                        — {{ $enrollment->program->title }}
                    </option>
                @endforeach
            </select>

            <small class="text-muted">
                Shows only active enrollments
            </small>
        </div>

        <!-- Week -->
        <div class="mb-3">
            <label class="form-label">Week Number</label>
            <input type="number"
                   name="week_number"
                   min="1"
                   max="12"
                   class="form-control"
                   required>
        </div>

        <!-- Scores -->
        <div class="row">
            <div class="col-6 col-md-3 mb-3">
                <label class="form-label">Flexibility</label>
                <input type="number" step="0.1" name="flexibility_score" class="form-control">
            </div>

            <div class="col-6 col-md-3 mb-3">
                <label class="form-label">Strength</label>
                <input type="number" step="0.1" name="strength_score" class="form-control">
            </div>

            <div class="col-6 col-md-3 mb-3">
                <label class="form-label">Balance</label>
                <input type="number" step="0.1" name="balance_score" class="form-control">
            </div>

            <div class="col-6 col-md-3 mb-3">
                <label class="form-label">Mindset</label>
                <input type="number" step="0.1" name="mindset_score" class="form-control">
            </div>
        </div>

        <!-- Instructor Notes -->
        <div class="mb-3">
            <label class="form-label">Instructor Notes</label>
            <textarea name="instructor_notes" rows="3" class="form-control"></textarea>
        </div>

        <!-- Overall Feedback -->
        <div class="mb-3">
            <label class="form-label">Overall Feedback</label>
            <textarea name="overall_feedback" rows="3" class="form-control"></textarea>
        </div>

        <!-- Media -->
        <div class="mb-4">
            <label class="form-label">Upload Best Moment (Photo / Video)</label>
            <input type="file" name="media" class="form-control">
        </div>

        <button class="btn btn-success w-100">
            💾 Save Weekly Progress
        </button>
    </form>
</div>
@endsection
