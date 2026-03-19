@extends('layouts.app')

@section('title','Edit Assignment')

@section('content')
<div class="container py-4">

    <h2 class="mb-4 text-success fw-bold text-center display-6">✏️ Edit Assignment</h2>

    <form action="{{ route('admin.assignments.update', $assignment) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Title</label>
            <input type="text" name="title" class="form-control" value="{{ old('title', $assignment->title) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="3">{{ old('description', $assignment->description) }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Due Date</label>
            <input type="date" name="due_date" class="form-control" value="{{ old('due_date', $assignment->due_date->format('Y-m-d')) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Assign to Students</label>
            <select name="students[]" class="form-select" multiple required>
                @foreach($students as $student)
                    <option value="{{ $student->id }}" 
                        {{ in_array($student->id, $assignedIds) ? 'selected' : '' }}>
                        {{ $student->name }} ({{ $student->email }})
                    </option>
                @endforeach
            </select>
            <small class="text-muted">Hold Ctrl (Cmd) to select multiple students.</small>
        </div>

        <div class="mb-3">
            <label class="form-label">Task File (optional, upload to replace)</label>
            <input type="file" name="media" class="form-control">
            @if($assignment->media_path)
                <small class="text-muted">Current file: <a href="{{ asset('storage/'.$assignment->media_path) }}" target="_blank">View</a></small>
            @endif
        </div>

        <button type="submit" class="btn btn-success">Update Assignment</button>
        <a href="{{ route('admin.assignments.index') }}" class="btn btn-secondary">Cancel</a>
    </form>

</div>
@endsection
