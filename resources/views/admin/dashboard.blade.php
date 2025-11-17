@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid">
    <h1 class="mb-4">Welcome, Admin</h1>

    <div class="row">
        <div class="col-md-4 mb-3">
            <div class="card card-theme p-3">
                <h5>Courses</h5>
                <p>Total Courses: {{ $coursesCount ?? 0 }}</p>
                <a href="{{ route('admin.courses.index') }}" class="btn btn-theme btn-sm">Manage Courses</a>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card card-theme p-3">
                <h5>Assignments</h5>
                <p>Total Assignments: {{ $assignmentsCount ?? 0 }}</p>
                <a href="{{ route('admin.assignments.index') }}" class="btn btn-theme btn-sm">Manage Assignments</a>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card card-theme p-3">
                <h5>Submissions</h5>
                <p>Total Submissions: {{ $submissionsCount ?? 0 }}</p>
                <a href="{{ route('admin.submissions.index') }}" class="btn btn-theme btn-sm">View Submissions</a>
            </div>
        </div>
    </div>
</div>
@endsection
