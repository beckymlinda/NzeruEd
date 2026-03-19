@extends('layouts.app')

@section('title', 'My Programs')

@section('content')
<div class="container py-4">

    <h2 class="mb-4 text-success fw-bold text-center display-6">
        🧘 Your Yoga Programs
    </h2>

    <div class="row g-4">
        @foreach($programs as $program)
            @php
                $isEnrolled = $program->id == $enrolledProgramId;

                // Image mapping (public folder)
                $images = [
                    1 => 'images/im1.jpg',
                    2 => 'images/im2.jpg',
                    3 => 'images/im3.jpg',
                ];

                $imagePath = $images[$program->id] ?? 'images/im1.jpg';
            @endphp

            <div class="col-12 col-md-6 col-lg-4">
                <div class="card h-100 shadow-sm border-0 {{ $isEnrolled ? 'border-success' : 'bg-light text-muted' }}">

                    <!-- Program Image -->
                    <div class="ratio ratio-4x3 bg-white">
                        <img
                            src="{{ asset($imagePath) }}"
                            alt="{{ $program->title }}"
                            class="img-fluid p-2"
                            style="object-fit: contain;"
                        >
                    </div>

                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title fw-bold text-dark">
                            {{ $program->title }}
                        </h5>

                        <p class="card-text flex-grow-1">
                            {{ Str::limit($program->description, 110) }}
                        </p>

                        <ul class="list-unstyled mb-3 small">
                            <li><strong>Duration:</strong> {{ $program->duration_weeks }} weeks</li>
                            <li><strong>Sessions:</strong> {{ $program->total_sessions }}</li>
                            <li><strong>Level:</strong> {{ ucfirst($program->level) }}</li>
                            <li><strong>Price:</strong> MWK {{ number_format($program->price, 0) }}</li>
                        </ul>

                        @if($isEnrolled)
                            <a href="{{ route('student.programs.show', $program->id) }}"
                               class="btn btn-success w-100">
                                View Program
                            </a>
                        @else
                            <button class="btn btn-outline-secondary w-100" disabled>
                                Locked
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>

</div>
@endsection
