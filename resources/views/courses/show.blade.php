@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4 text-primary">{{ $course->title }}</h1>
    <p>{{ $course->description }}</p>

    <h3 class="mt-4 text-light">Assignments</h3>
    <div class="list-group">
        @foreach($assignments as $assignment)
            <a href="{{ route('assignments.show', $assignment) }}" class="list-group-item list-group-item-action">
                {{ $assignment->title }}
            </a>
        @endforeach
    </div>
</div>
@endsection
