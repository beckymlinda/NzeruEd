@extends('layouts.app')

@section('title', 'Assignments')

@section('content')
<div class="container py-4">

    <h2 class="mb-4 text-success fw-bold text-center display-6">📝 Assignments</h2>

    <div class="mb-3 text-center">
        <a href="{{ route('admin.assignments.create') }}" class="btn btn-success">➕ Create New Assignment</a>
    </div>
@forelse($assignments as $assignment)
    <div class="card mb-4 shadow-sm">
        <div class="card-body d-flex flex-column flex-md-row justify-content-between align-items-start">
            <div>
                <h5 class="fw-bold">{{ $assignment->title }}</h5>
                <p class="text-muted mb-1">{{ $assignment->description }}</p>
                <p><strong>Due Date:</strong> {{ \Carbon\Carbon::parse($assignment->due_date)->format('M d, Y') }}</p>

                @if($assignment->media_path)
                    <p>
                        <a href="{{ asset('storage/'.$assignment->media_path) }}" target="_blank">View Task File</a>
                    </p>
                @endif

                <h6 class="mt-3">Submissions:</h6>
                @if($assignment->submissions->count())
                    <ul class="list-unstyled">
                        @foreach($assignment->submissions as $sub)
                            <li>
                                <strong>{{ $sub->student->name }}</strong> - 
                                <a href="{{ asset('storage/'.$sub->file_path) }}" target="_blank">View Submission</a>
                                @if($sub->notes)
                                    | Notes: {{ $sub->notes }}
                                @endif
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-muted">No submissions yet.</p>
                @endif
            </div>

            <!-- Action buttons -->
            <div class="mt-3 mt-md-0 ms-md-3 d-flex flex-column gap-2">
                <a href="{{ route('admin.assignments.edit', $assignment) }}" class="btn btn-primary btn-sm">✏️ Edit</a>

                <form action="{{ route('admin.assignments.destroy', $assignment) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this assignment?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">🗑️ Delete</button>
                </form>
            </div>
        </div>
    </div>
@empty
    <div class="alert alert-info text-center">No assignments created yet.</div>
@endforelse


</div>
@endsection
