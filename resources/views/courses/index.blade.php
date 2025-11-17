@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4 text-primary">Available Courses</h1>

    <div class="row">
        @foreach($courses as $course)
        <div class="col-md-4 mb-3">
            <div class="card h-100 shadow-sm border-0" style="background: linear-gradient(to bottom, #6a0dad, #1e3c72); color:white;">
                <div class="card-body">
                    <h5 class="card-title">{{ $course->title }}</h5>
                    <p class="card-text">{{ Str::limit($course->description, 80) }}</p>
                    <a href="{{ route('assignments.index', $course) }}" class="btn btn-light text-primary">View Assignments</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
