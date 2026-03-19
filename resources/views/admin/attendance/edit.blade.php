@extends('layouts.app')

@section('title', 'Edit Attendance')

@section('content')
<div class="container py-4">

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-header bg-warning text-white rounded-top-4">
            <strong>✏️ Edit Attendance Record</strong>
            <div class="mt-2">
                <small>
                    Student: {{ $attendance->enrollment->user->name }} | 
                    Date: {{ $attendance->session_date->format('M d, Y') }} |
                    Session: Week {{ $attendance->week_number ?? 'N/A' }}, Session {{ $attendance->session_number ?? 'N/A' }}
                </small>
            </div>
        </div>

        <div class="card-body">
           <form method="POST" action="{{ route('admin.attendance.update', $attendance->id) }}">
    @csrf
    @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Student</label>
                    <select name="enrollment_id" class="form-select" required>
                        <option value="">Select student</option>
                        @foreach($enrollments as $enrollment)
                            <option value="{{ $enrollment->id }}" 
                                {{ $attendance->enrollment_id == $enrollment->id ? 'selected' : '' }}>
                                {{ $enrollment->user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Date</label>
                        <input type="date" name="session_date" class="form-control" required 
                               value="{{ $attendance->session_date->format('Y-m-d') }}">
                    </div>

                    <div class="col-md-2">
                        <label class="form-label">Week Number</label>
                        <input type="number" name="week_number" class="form-control" min="1" max="4" required 
                               value="{{ $attendance->week_number ?? 1 }}" placeholder="1-4">
                    </div>

                    <div class="col-md-2">
                        <label class="form-label">Session Number</label>
                        <input type="number" name="session_number" class="form-control" min="1" max="3" required 
                               value="{{ $attendance->session_number ?? 1 }}" placeholder="1-3">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select" required>
                            <option value="present" {{ $attendance->status == 'present' ? 'selected' : '' }}>Present</option>
                            <option value="missed" {{ $attendance->status == 'missed' ? 'selected' : '' }}>Missed</option>
                        </select>
                    </div>
                </div>

                <div class="row g-3 mt-2">
                    <div class="col-md-6">
                        <label class="form-label">Payment Status</label>
                        <select name="payment_status" class="form-select" required>
                            <option value="unpaid" {{ ($attendance->payment_status ?? 'unpaid') == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                            <option value="paid" {{ ($attendance->payment_status ?? 'unpaid') == 'paid' ? 'selected' : '' }}>Paid</option>
                            <option value="partial" {{ ($attendance->payment_status ?? 'unpaid') == 'partial' ? 'selected' : '' }}>Partial</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Reason (optional)</label>
                        <textarea name="reason" class="form-control" rows="2" placeholder="Reason for absence if missed...">{{ $attendance->reason }}</textarea>
                    </div>
                </div>

                <div class="mt-4 d-flex justify-content-between">
                    <a href="{{ route('admin.attendance.index') }}" class="btn btn-secondary">
                        ← Cancel
                    </a>
                    <div>
                        <button type="submit" class="btn btn-warning px-4">
                            Update Attendance
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
