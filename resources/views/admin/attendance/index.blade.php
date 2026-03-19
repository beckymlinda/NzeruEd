@extends('layouts.app')

@section('title', 'Attendance Overview')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">
            <i class="bi bi-people text-primary"></i> Attendance Overview
        </h2>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.attendance.create') }}" class="btn btn-success">
                <i class="bi bi-plus-circle"></i> Record Attendance
            </a>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="row g-3 mb-4">
        <div class="col-12 col-md-3">
            <div class="card border-0 shadow-sm bg-gradient-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-0">Total Students</h6>
                            <h3 class="mb-0">{{ count($attendanceData) }}</h3>
                        </div>
                        <div class="fs-1 opacity-50">
                            <i class="bi bi-people"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-3">
            <div class="card border-0 shadow-sm bg-gradient-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-0">Total Sessions</h6>
                            <h3 class="mb-0">{{ array_sum(array_column($attendanceData, 'total_sessions')) }}</h3>
                        </div>
                        <div class="fs-1 opacity-50">
                            <i class="bi bi-calendar-check"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-3">
            <div class="card border-0 shadow-sm bg-gradient-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-0">Present Sessions</h6>
                            <h3 class="mb-0">{{ array_sum(array_column($attendanceData, 'present_sessions')) }}</h3>
                        </div>
                        <div class="fs-1 opacity-50">
                            <i class="bi bi-check-circle"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-3">
            <div class="card border-0 shadow-sm bg-gradient-warning text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-0">Avg Attendance</h6>
                            <h3 class="mb-0">
                                @php
                                    $totalSessions = array_sum(array_column($attendanceData, 'total_sessions'));
                                    $presentSessions = array_sum(array_column($attendanceData, 'present_sessions'));
                                    $avgAttendance = $totalSessions > 0 ? round(($presentSessions / $totalSessions) * 100, 1) : 0;
                                @endphp
                                {{ $avgAttendance }}%
                            </h3>
                        </div>
                        <div class="fs-1 opacity-50">
                            <i class="bi bi-graph-up"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Student List Table -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">📋 Student Attendance List</h5>
        </div>
        <div class="card-body">
            @if(empty($attendanceData))
                <div class="text-center py-5">
                    <i class="bi bi-people text-muted" style="font-size: 4rem;"></i>
                    <h4 class="text-muted mt-3">No Students Found</h4>
                    <p class="text-muted">No active enrollments found.</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Student</th>
                                <th>Email</th>
                                <th>Total Sessions</th>
                                <th>Present</th>
                                <th>Attendance Rate</th>
                                <th>Payment Status</th>
                                <th>Last Attendance</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($attendanceData as $data)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 35px; height: 35px;">
                                                {{ strtoupper(substr($data['student']->name, 0, 1)) }}
                                            </div>
                                            <strong>{{ $data['student']->name }}</strong>
                                        </div>
                                    </td>
                                    <td>{{ $data['student']->email }}</td>
                                    <td>
                                        <span class="badge bg-info">{{ $data['total_sessions'] }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-success">{{ $data['present_sessions'] }}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="progress me-2" style="width: 60px; height: 8px;">
                                                <div class="progress-bar {{ $data['attendance_rate'] >= 80 ? 'bg-success' : ($data['attendance_rate'] >= 60 ? 'bg-warning' : 'bg-danger') }}" 
                                                     style="width: {{ $data['attendance_rate'] }}%">
                                                </div>
                                            </div>
                                            <small class="text-muted">{{ $data['attendance_rate'] }}%</small>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge {{ $data['payment_status']['status'] === 'paid' ? 'bg-success' : 'bg-warning' }}">
                                            {{ $data['payment_status']['percentage'] }}% Paid
                                        </span>
                                    </td>
                                    <td>
                                        @if($data['last_attendance'])
                                            <small>{{ $data['last_attendance']->session_date->format('M d, Y') }}</small>
                                            <br>
                                            <span class="badge {{ $data['last_attendance']->status === 'present' ? 'bg-success' : 'bg-danger' }} badge-sm">
                                                {{ ucfirst($data['last_attendance']->status) }}
                                            </span>
                                        @else
                                            <span class="text-muted">No records</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('admin.attendance.show', $data['student']->id) }}" 
                                               class="btn btn-primary btn-sm">
                                                <i class="bi bi-eye me-1"></i> View Details
                                            </a>
                                            <a href="{{ route('admin.attendance.create') }}?student={{ $data['student']->id }}" 
                                               class="btn btn-success btn-sm">
                                                <i class="bi bi-plus-circle me-1"></i> Record
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Custom Styles -->
<style>
.bg-gradient-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
}

.bg-gradient-success {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%) !important;
}

.bg-gradient-info {
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%) !important;
}

.bg-gradient-warning {
    background: linear-gradient(135deg, #fa709a 0%, #fee140 100%) !important;
}

.card {
    transition: transform 0.2s ease-in-out;
}

.card:hover {
    transform: translateY(-2px);
}

.avatar-sm {
    font-weight: bold;
    font-size: 0.875rem;
}

.badge {
    font-size: 0.75rem;
}

.btn-group-sm .btn {
    padding: 0.25rem 0.5rem;
    font-size: 0.75rem;
}

.btn-sm {
    padding: 0.375rem 0.75rem;
    font-size: 0.875rem;
    font-weight: 500;
    border-radius: 0.375rem;
    min-width: 100px;
}

.btn-sm i {
    font-size: 0.875rem;
}

.d-flex.gap-2 .btn-sm {
    min-width: auto;
}

.progress {
    background-color: #e9ecef;
}

.progress-bar {
    font-size: 0.6rem;
    line-height: 8px;
}
</style>
@endsection
