@extends('layouts.app')

@section('title', 'Weekly Poses')

@section('content')
<div class="container py-5">
<!-- Add Weekly Pose Button -->
<div class="mb-4 text-end">
    <a href="{{ route('admin.weekly-poses.create') }}" 
       class="btn btn-success fw-bold px-4 py-2 shadow-sm"
       style="background: linear-gradient(90deg, #6a0dad, #1e90ff); border: none; color: #fff;">
        ➕ Add Weekly Pose
    </a>
</div>

    <h2 class="text-center text-success fw-bold mb-5">🧘 Weekly Poses</h2>

    @if($poses->isEmpty())
        <div class="alert alert-info text-center">
            No poses added yet. Create some to guide your students.
        </div>
    @else
        <div class="row g-4">
            @foreach($poses as $pose)
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card shadow-sm rounded-3 h-100">

                        {{-- Image --}}
                        @if($pose->media_path)
                            <div class="pose-image-wrapper">
                                <img src="{{ asset('storage/'.$pose->media_path) }}"
                                     alt="{{ $pose->pose_name }}"
                                     class="pose-image">
                            </div>
                        @else
                            <div class="pose-image-wrapper d-flex align-items-center justify-content-center">
                                <span class="text-muted">No image</span>
                            </div>
                        @endif

                        {{-- Card Body --}}
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title fw-semibold">{{ $pose->pose_name }}</h5>

                            <p class="mb-1">
                                <strong>Week:</strong>
                                @if($pose->weeklyTarget)
                                    Week {{ $pose->weeklyTarget->week_number }} – {{ $pose->weeklyTarget->focus_area }}
                                @else
                                    <span class="text-danger">Not assigned</span>
                                @endif
                            </p>

                            <p class="mb-1"><strong>Hold Time:</strong> {{ $pose->hold_time_seconds ?? '-' }} seconds</p>

                            @if($pose->notes)
                                <p class="mb-0"><strong>Notes:</strong> {{ $pose->notes }}</p>
                            @endif

                            <div class="mt-auto d-flex justify-content-between align-items-center pt-3">
                                {{-- Edit Button --}}
                                <a href="{{ route('admin.weekly-poses.edit', $pose->id) }}"
                                   class="btn btn-sm btn-outline-success">Edit</a>

                                {{-- Delete Button --}}
                                <form action="{{ route('admin.weekly-poses.destroy', $pose->id) }}" method="POST" 
                                      onsubmit="return confirm('Are you sure you want to delete this pose?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

</div>

{{-- Custom CSS --}}
<style>
.pose-image-wrapper {
    width: 100%;
    height: 220px;
    background: linear-gradient(135deg, #f0f7f4, #e6f4ea);
    border-top-left-radius: .75rem;
    border-top-right-radius: .75rem;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
}

.pose-image {
    width: 100%;
    height: 100%;
    object-fit: contain; /* Show full image without cropping */
    transition: transform 0.3s ease;
}

.pose-image:hover {
    transform: scale(1.05);
}

.card-title {
    font-size: 1.2rem;
}

@media (max-width: 768px) {
    .pose-image-wrapper {
        height: 180px;
    }
}
</style>
@endsection
