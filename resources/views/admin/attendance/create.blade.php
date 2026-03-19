@extends('layouts.app')

@section('title', 'Record Attendance')

@section('content')
<div class="container py-4">

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-header bg-success text-white rounded-top-4">
            <strong>📅 Record Attendance</strong>
        </div>

        <div class="card-body">
           <form method="POST" action="{{ route('admin.attendance.store') }}">
    @csrf

                <div class="mb-3">
                    <label class="form-label">Student</label>
                    <select name="enrollment_id" class="form-select" required>
                        <option value="">Select student</option>
                        @foreach($enrollments as $enrollment)
                            <option value="{{ $enrollment->id }}">
                                {{ $enrollment->user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Date</label>
                        <input type="date" name="session_date" class="form-control" required>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label">Week Number</label>
                        <input type="number" name="week_number" class="form-control" min="1" max="4" required placeholder="1-4">
                    </div>

                    <div class="col-md-2">
                        <label class="form-label">Session Number</label>
                        <input type="number" name="session_number" class="form-control" min="1" max="3" required placeholder="1-3">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select" required>
                            <option value="present">Present</option>
                            <option value="missed">Missed</option>
                        </select>
                    </div>
                </div>

                <div class="row g-3 mt-2">
                    <div class="col-md-6">
                        <label class="form-label">Payment Status</label>
                        <select name="payment_status" class="form-select" required>
                            <option value="unpaid">Unpaid</option>
                            <option value="paid">Paid</option>
                            <option value="partial">Partial</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Reason (optional)</label>
                        <textarea name="reason" class="form-control" rows="2" placeholder="Reason for absence if missed..."></textarea>
                    </div>
                </div>

                <div class="mt-4 text-end">
                    <button class="btn btn-success px-4">
                        Save Attendance
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
