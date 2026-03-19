@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container-fluid">

    <!-- Summary Cards -->
    <div class="row g-3 mb-4">
        <div class="col-12 col-md-4">
            <div class="card shadow-sm rounded border-0 p-3" style="background-color: #fdf6f0;">
                <h6 class="text-muted">Total Students</h6>
                <p class="display-6 fw-bold">{{ $totalStudents }}</p>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="card shadow-sm rounded border-0 p-3" style="background-color: #f0f9f4;">
                <h6 class="text-muted">Active Enrollments</h6>
                <p class="display-6 fw-bold">{{ $activeEnrollments }}</p>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="card shadow-sm rounded border-0 p-3" style="background-color: #f0f4fd;">
                <h6 class="text-muted">Total Payments</h6>
                <p class="display-6 fw-bold">MWK {{ number_format($totalPayments, 2) }}</p>
            </div>
        </div>
    </div>

    <!-- Recent Weekly Progress -->
    <div class="mb-4">
        <h5 class="mb-3 text-primary">Recent Weekly Progress</h5>
        <div class="list-group">
            @foreach($recentProgress as $progress)
                <div class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                    Week {{ $progress->week_number }} - {{ $progress->enrollment->user->name ?? 'Student' }}
                </div>
            @endforeach
        </div>
    </div>

    <!-- Recent Attendance -->
    <div class="mb-4">
        <h5 class="mb-3 text-primary">Recent Attendance</h5>
        <div class="list-group">
            @foreach($recentAttendance as $att)
                <div class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                    <span>{{ $att->session_date->format('M d, Y') }} - {{ $att->enrollment->user->name ?? 'Student' }}</span>
                    <span class="badge 
                        {{ $att->status === 'present' ? 'bg-success' : 'bg-danger' }}">
                        {{ ucfirst($att->status) }}
                    </span>
                </div>
            @endforeach
        </div>
    </div>

</div>
@endsection
