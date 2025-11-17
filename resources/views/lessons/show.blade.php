@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $lesson->title }}</h1>
    <h5>Course: {{ $lesson->course->title }}</h5>
    @if($lesson->summary)
        <p>{{ $lesson->summary }}</p>
    @endif

    @if($lesson->video_url)
        <div class="mb-3">
            <video width="640" controls>
                <source src="{{ $lesson->video_url }}" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        </div>
    @endif

    @if($lesson->attachment_path)
        <a href="{{ asset('storage/' . $lesson->attachment_path) }}" class="btn btn-primary" download>
            Download Attachment
        </a>
    @endif
</div>
@endsection
