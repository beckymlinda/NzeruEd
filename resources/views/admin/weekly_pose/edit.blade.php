@extends('layouts.app')

@section('title', 'Edit Weekly Pose')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8">

            <div class="card shadow-sm rounded-3">
                <div class="card-header text-center text-white fw-bold" style="background: linear-gradient(90deg, #6a0dad, #1e90ff);">
                    🧘 Edit Weekly Pose
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success text-center">
                            {{ session('success') }}
                        </div>
                    @endif

                <form action="{{ route('admin.weekly-poses.update', $weeklyPose->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

                        <!-- Weekly Target -->
                        <div class="mb-3">
                            <label for="weekly_target_id" class="form-label fw-semibold">Weekly Target</label>
                            <select name="weekly_target_id" id="weekly_target_id" class="form-select">
                                <option value="">-- Select Weekly Target --</option>
                                @foreach($weeklyTargets as $target)
                                    <option value="{{ $target->id }}" 
                                        {{ $weeklyPose->weekly_target_id == $target->id ? 'selected' : '' }}>
                                        Week {{ $target->week_number }} – {{ $target->focus_area }}
                                    </option>
                                @endforeach
                            </select>
                            @error('weekly_target_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Student Assignments -->
                        <div class="mb-3">
                            <label for="students" class="form-label fw-semibold">Assign to Students (optional)</label>
                            <select name="students[]" id="students" class="form-select" multiple size="5">
                                <option value="">-- Select Students --</option>
                                @php
                                    $enrolledStudents = \App\Models\User::where('role', 'student')
                                        ->whereHas('enrollments', function($query) {
                                            $query->where('status', 'active');
                                        })
                                        ->orderBy('name')
                                        ->get();
                                    
                                    $assignedStudentIds = $weeklyPose->students()->pluck('users.id')->toArray();
                                @endphp
                                @foreach($enrolledStudents as $student)
                                    <option value="{{ $student->id }}" 
                                        {{ in_array($student->id, $assignedStudentIds) ? 'selected' : '' }}>
                                        {{ $student->name }} ({{ $student->email }})
                                    </option>
                                @endforeach
                            </select>
                            <small class="text-muted d-block mt-1">Hold Ctrl/Cmd to select multiple students. If no students are selected, this pose will be visible to all enrolled students.</small>
                            @error('students')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Pose Name -->
                        <div class="mb-3">
                            <label for="pose_name" class="form-label fw-semibold">Pose Name</label>
                            <input type="text" id="pose_name" name="pose_name" value="{{ old('pose_name', $weeklyPose->pose_name) }}" 
                                   class="form-control" placeholder="E.g. Cobra Pose">
                            @error('pose_name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Hold Time -->
                        <div class="mb-3">
                            <label for="hold_time_seconds" class="form-label fw-semibold">Hold Time (seconds)</label>
                            <input type="number" id="hold_time_seconds" name="hold_time_seconds" 
                                   value="{{ old('hold_time_seconds', $weeklyPose->hold_time_seconds) }}" 
                                   class="form-control" placeholder="30">
                            @error('hold_time_seconds')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Notes -->
                        <div class="mb-3">
                            <label for="notes" class="form-label fw-semibold">Instructor Notes</label>
                            <textarea id="notes" name="notes" rows="3" class="form-control" placeholder="Alignment tips, breathing cues…">{{ old('notes', $weeklyPose->notes) }}</textarea>
                            @error('notes')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Image Upload -->
                        <div class="mb-3">
                            <label for="media" class="form-label fw-semibold">Pose Image</label>
                            @if($weeklyPose->media_path)
                                <div class="mb-2 text-center">
                                    <img src="{{ asset('storage/'.$weeklyPose->media_path) }}" 
                                         alt="{{ $weeklyPose->pose_name }}" 
                                         class="img-fluid rounded shadow-sm" 
                                         style="max-height:300px; object-fit:contain;">
                                </div>
                            @endif
                            <input type="file" id="media" name="media" class="form-control">
                            @error('media')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                            <small class="text-muted d-block mt-1">Upload a new image to replace the current one (optional).</small>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary fw-bold">
                                Update Pose
                            </button>
                            <a href="{{ route('admin.weekly-poses.index') }}" class="btn btn-outline-secondary">
                                Cancel
                            </a>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
