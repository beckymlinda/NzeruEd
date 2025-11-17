@extends('admin.layouts.app')

@section('title', 'Add Course')

@section('content')
<h1 class="mb-4">Add New Course</h1>

<form action="{{ route('admin.courses.store') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label class="form-label">Course Title</label>
        <input type="text" name="title" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Instructor</label>
        <input type="text" name="instructor" class="form-control">
    </div>
    <button type="submit" class="btn btn-theme">Save Course</button>
</form>
@endsection
