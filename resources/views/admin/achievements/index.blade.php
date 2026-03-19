@extends('layouts.app')

@section('title', 'Achievements')

@section('content')
<div class="container py-5">
    <h2 class="text-center text-success fw-bold mb-5">🏅 Student Achievements</h2>

    <!-- Award Achievement Form -->
    <div class="row mb-5">
        <div class="col-12 col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">Award New Achievement</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.achievements.store') }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="enrollment_id" class="form-label">Student</label>
                                <select name="enrollment_id" id="enrollment_id" class="form-select" required>
                                    <option value="">Select Student</option>
                                    @php
                                        $enrollments = \App\Models\Enrollment::with('user')
                                            ->where('status', 'active')
                                            ->get();
                                    @endphp
                                    @foreach($enrollments as $enrollment)
                                        <option value="{{ $enrollment->id }}">
                                            {{ $enrollment->user->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('enrollment_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="achievement_id" class="form-label">Achievement</label>
                                <select name="achievement_id" id="achievement_id" class="form-select" required>
                                    <option value="">Select Achievement</option>
                                    @foreach($achievements as $achievement)
                                        <option value="{{ $achievement->id }}">
                                            {{ $achievement->title }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('achievement_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="awarded_week" class="form-label">Week</label>
                                <input type="number" name="awarded_week" id="awarded_week" 
                                       class="form-control" min="1" max="12" required>
                                @error('awarded_week')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="notes" class="form-label">Notes (optional)</label>
                                <input type="text" name="notes" id="notes" class="form-control"
                                       placeholder="Additional notes...">
                                @error('notes')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <button type="submit" class="btn btn-success">
                            🏅 Award Achievement
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Achievements -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Recent Achievements Awarded</h5>
                </div>
                <div class="card-body">
                    @if($studentAchievements->isEmpty())
                        <div class="alert alert-info text-center">
                            No achievements awarded yet. Start by awarding one above!
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Student</th>
                                        <th>Achievement</th>
                                        <th>Week</th>
                                        <th>Notes</th>
                                        <th>Awarded Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($studentAchievements as $studentAchievement)
                                        <tr>
                                            <td>
                                                {{ $studentAchievement->enrollment->user->name ?? 'N/A' }}
                                            </td>
                                            <td>
                                                <span class="badge bg-success">
                                                    {{ $studentAchievement->achievement->title ?? 'N/A' }}
                                                </span>
                                            </td>
                                            <td>Week {{ $studentAchievement->awarded_week }}</td>
                                            <td>{{ $studentAchievement->notes ?? '-' }}</td>
                                            <td>{{ $studentAchievement->created_at->format('M d, Y') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
</div>
@endsection
