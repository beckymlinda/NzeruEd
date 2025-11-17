@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Lessons</h1>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <ul class="list-group">
        @foreach($lessons as $lesson)
            <li class="list-group-item">
                <a href="{{ route('lessons.show', $lesson) }}">
                    {{ $lesson->title }} 
                    ({{ $lesson->course->title }}) 
                    @if($lesson->is_free) <span class="badge bg-success">Free</span> @endif
                </a>
            </li>
        @endforeach
    </ul>
</div>
@endsection
