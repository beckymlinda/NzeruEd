@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4" style="color:#5b2cff;">{{ $course->title }}</h1>
    <p class="mb-4 text-muted">Select an assignment to view details and submit your work.</p>

    @if($assignments->isEmpty())
        <div class="alert alert-info">
            No assignments have been added for this course yet.
        </div>
    @else
        <div class="row">
            @foreach($assignments as $assignment)
                <div class="col-md-6 mb-4">
                    <div class="card shadow-sm border-0" style="background: linear-gradient(135deg, #5b2cff, #2d9cff); color: #fff;">
                        <div class="card-body">
                            <h5 class="card-title">{{ $assignment->title }}</h5>
                            @if($assignment->instructions)
                                <p class="card-text">{{ Str::limit($assignment->instructions, 80) }}</p>
                            @endif
                            <a href="{{ route('assignments.show', $assignment) }}" class="btn btn-light">
                                View & Submit
                            </a>
                        </div>
                        <div class="card-footer text-white-50">
                            Due: {{ $assignment->due_date ? $assignment->due_date->format('M d, Y') : 'No due date' }}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <a href="{{ route('courses.index') }}" class="btn btn-outline-primary mt-3">Back to Courses</a>
</div>
@endsection
