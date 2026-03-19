@extends('layouts.app')

@section('title', 'Add Weekly Pose')

@section('content')
<div class="container py-4">

    <h2 class="mb-4">🧘 Add Pose</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('admin.weekly-poses.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-4 rounded shadow-sm">
        @csrf

        <div class="mb-3">
            <label>Weekly Target</label>
            <select name="weekly_target_id" class="form-select">
                <option value="">-- Select Weekly Target --</option>
                @foreach($weeklyTargets as $target)
                    <option value="{{ $target->id }}">Week {{ $target->week_number }} – {{ $target->focus_area }}</option>
                @endforeach
            </select>
            @error('weekly_target_id') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label>Assign to Students (optional - leave empty to assign to all enrolled students)</label>
            <select name="students[]" class="form-select" multiple size="5">
                <option value="">-- Select Students --</option>
                @php
                    $enrolledStudents = \App\Models\User::where('role', 'student')
                        ->whereHas('enrollments', function($query) {
                            $query->where('status', 'active');
                        })
                        ->orderBy('name')
                        ->get();
                @endphp
                @foreach($enrolledStudents as $student)
                    <option value="{{ $student->id }}">{{ $student->name }} ({{ $student->email }})</option>
                @endforeach
            </select>
            <small class="text-muted">Hold Ctrl/Cmd to select multiple students. If no students are selected, this pose will be visible to all enrolled students.</small>
            @error('students') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label>Pose Name</label>
            <input type="text" name="pose_name" class="form-control" placeholder="Cobra Pose">
            @error('pose_name') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label>Hold Time (seconds)</label>
            <input type="number" name="hold_time_seconds" class="form-control">
            @error('hold_time_seconds') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label>Notes</label>
            <textarea name="notes" class="form-control" rows="3"></textarea>
        </div>

        <div class="mb-3">
            <label>Pose Image (optional)</label>
            <input type="file" name="media" class="form-control">
        </div>

        <button type="submit" class="btn btn-success w-100">Save Pose</button>
    </form>
</div>
@endsection
