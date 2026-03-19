@extends('layouts.app')

@section('title', 'Create Assignment')

@section('content')
<div class="container py-4">

    <h2 class="mb-4 text-success fw-bold text-center display-6">➕ Create Assignment</h2>

    <form action="{{ route('admin.assignments.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
    <label class="form-label">Assign to Students</label>
    <select name="students[]" class="form-select" multiple required>
        @foreach($students as $student)
            <option value="{{ $student->id }}">{{ $student->name }} ({{ $student->email }})</option>
        @endforeach
    </select>
    <small class="text-muted">Hold Ctrl (Cmd) to select multiple students.</small>
</div>


        <div class="mb-3">
            <label class="form-label">Title</label>
            <input type="text" name="title" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="4"></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Due Date</label>
            <input type="date" name="due_date" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Optional File (PDF, Image, Video)</label>
            <input type="file" name="media" class="form-control">
        </div>

        <button class="btn btn-success">Create Assignment</button>
    </form>

</div>
@endsection
