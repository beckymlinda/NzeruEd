@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $assignment->title }}</h1>
    <h5>Course: {{ $assignment->course->title }}</h5>

    @if($assignment->instructions)
        <p>{{ $assignment->instructions }}</p>
    @endif

    @if($assignment->attachment)
        <a href="{{ asset('storage/' . $assignment->attachment) }}" class="btn btn-primary" download>
            Download Assignment File
        </a>
    @endif

    <form action="{{ route('submissions.store', $assignment) }}" method="POST" enctype="multipart/form-data" class="mt-3">
        @csrf
        <div class="mb-3">
            <label for="file" class="form-label">Upload Your Submission</label>
            <input type="file" name="file" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Submit Assignment</button>
    </form>
</div>
@endsection
