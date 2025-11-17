@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm border-0">
        <div class="card-header text-white fw-bold" style="background: linear-gradient(90deg, #1e90ff, #6a0dad);">
            {{ $assignment->title }}
        </div>

        <div class="card-body">
            <h5 class="mb-3" style="color:#1e90ff;">Course: {{ $assignment->course->title }}</h5>

            @if($assignment->instructions)
                <p class="text-dark">{{ $assignment->instructions }}</p>
            @endif

            @if($assignment->attachment)
                <a href="{{ asset('storage/' . $assignment->attachment) }}" 
                   class="btn btn-outline-primary mb-3" download>
                   Download Assignment File
                </a>
            @endif

            <form action="{{ route('submissions.store', $assignment) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="file" class="form-label fw-bold" style="color:#6a0dad;">Upload Your Submission</label>
                    <input type="file" name="file" class="form-control border-purple bg-light-purple text-dark-purple" required>
                </div>
                <button type="submit" class="btn btn-gradient text-white fw-bold"
                        style="background: linear-gradient(90deg, #1e90ff, #6a0dad); border: none;">
                    Submit Assignment
                </button>
            </form>
        </div>
    </div>
</div>

<style>
    .border-purple { border-color: #6a0dad !important; }
    .bg-light-purple { background-color: #f3e6ff; }
    .text-dark-purple { color: #4b0082; }
    .btn-gradient:hover {
        background: linear-gradient(90deg, #6a0dad, #1e90ff) !important;
    }
</style>
@endsection
