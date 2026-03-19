@extends('layouts.app')

@section('title', $program->title)

@section('content')
<div class="container py-3 py-md-4">

    <!-- PROGRAM SUMMARY CARD -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body text-center">
            <h3 class="fw-bold text-success mb-2">
                {{ $program->title }}
            </h3>

            @if($program->description)
                <p class="text-muted mb-3">
                    {{ $program->description }}
                </p>
            @endif

            <div class="row text-center small">
                <div class="col-4">
                    <span class="fw-semibold d-block">Duration</span>
                    <span class="text-muted">{{ $program->duration_weeks }} weeks</span>
                </div>
                <div class="col-4">
                    <span class="fw-semibold d-block">Sessions</span>
                    <span class="text-muted">{{ $program->total_sessions }}</span>
                </div>
                <div class="col-4">
                    <span class="fw-semibold d-block">Level</span>
                    <span class="text-muted">{{ ucfirst($program->level) }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- WEEKLY TARGETS -->
    @forelse($program->weeklyTargets as $target)
        <div class="card shadow-sm border-0 mb-4">

            <!-- WEEK HEADER -->
            <div class="card-header bg-success text-white">
                <div class="fw-bold">
                    Week {{ $target->week_number }}
                </div>
                <small class="opacity-75">
                    Focus Area: {{ $target->focus_area }}
                </small>
            </div>

            <div class="card-body">

                <!-- WEEK DESCRIPTION -->
                @if($target->description)
                    <div class="mb-4">
                        <h6 class="fw-semibold text-secondary mb-2">
                            Weekly Guidance
                        </h6>
                        <p class="text-muted mb-0">
                            {!! nl2br(e($target->description)) !!}
                        </p>
                    </div>
                @endif

                <!-- POSES SECTION -->
                <h6 class="fw-semibold mb-3">
                    Poses for This Week
                </h6>

                @forelse($target->weeklyPoses as $pose)
                    <div class="card border-0 shadow-sm mb-3">

                        <div class="row g-0">

                            <!-- POSE IMAGE -->
                            <div class="col-12 col-md-4">
                                <div class="pose-image-wrapper">
                                    <img
                                        src="{{ $pose->media_path
                                            ? asset('storage/'.$pose->media_path)
                                            : asset('storage/weekly-poses/placeholder.jpg') }}"
                                        alt="{{ $pose->pose_name }}"
                                        class="img-fluid pose-image"
                                    >
                                </div>
                            </div>

                            <!-- POSE DETAILS -->
                            <div class="col-12 col-md-8">
                                <div class="card-body">

                                    <h6 class="fw-bold mb-2">
                                        {{ $pose->pose_name }}
                                    </h6>

                                    @if($pose->hold_time_seconds)
                                        <div class="small mb-2">
                                            <span class="fw-semibold">Hold Time:</span>
                                            <span class="text-muted">
                                                {{ $pose->hold_time_seconds }} seconds
                                            </span>
                                        </div>
                                    @endif

                                    @if($pose->notes)
                                        <div class="small text-muted">
                                            <span class="fw-semibold text-dark d-block mb-1">
                                                Instructor Notes
                                            </span>
                                            {!! nl2br(e($pose->notes)) !!}
                                        </div>
                                    @endif

                                </div>
                            </div>

                        </div>
                    </div>
                @empty
                    <p class="text-muted small">
                        No poses added for this week yet.
                    </p>
                @endforelse

            </div>
        </div>
    @empty
        <div class="alert alert-info text-center">
            No weekly targets have been added to this program yet.
        </div>
    @endforelse

</div>

<!-- STYLES -->
<style>
.pose-image-wrapper {
    width: 100%;
    padding: 1rem;
    background: #f8f9fa;
    display: flex;
    align-items: center;
    justify-content: center;
}

.pose-image {
    max-height: 220px;
    width: 100%;
    object-fit: contain;
    border-radius: 12px;
}

@media (min-width: 768px) {
    .pose-image {
        max-height: 260px;
    }
}
</style>
@endsection
