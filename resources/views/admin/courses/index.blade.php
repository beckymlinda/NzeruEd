@extends('admin.layouts.app')

@section('title', 'Courses')

@section('content')
<h1 class="mb-4">Courses</h1>
<a href="{{ route('admin.courses.create') }}" class="btn btn-theme mb-3">Add New Course</a>

<table class="table table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th>Title</th>
            <th>Instructor</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($courses as $course)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $course->title }}</td>
            <td>{{ $course->instructor ?? 'N/A' }}</td>
            <td>
                <a href="{{ route('admin.courses.edit', $course) }}" class="btn btn-sm btn-theme">Edit</a>
                <form action="{{ route('admin.courses.destroy', $course) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
