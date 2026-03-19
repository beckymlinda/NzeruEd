@extends('layouts.app')

@section('title', 'Student Attendance Details')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-0">
                <i class="bi bi-person-lines-fill text-primary"></i> 
                {{ $enrollment->user->name }} - Attendance Details
            </h2>
            <small class="text-muted">{{ $enrollment->user->email }}</small>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.attendance.index') }}" class="btn btn-outline-secondary">
                ← Back to Overview
            </a>
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
                            <h6 class="card-title mb-0">Total Sessions</h6>
                            <h3 class="mb-0">{{ $enrollment->attendance->count() }}</h3>
                        </div>
                        <div class="fs-1 opacity-50">
                            <i class="bi bi-calendar-check"></i>
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
                            <h6 class="card-title mb-0">Attendance Rate</h6>
                            <h3 class="mb-0">{{ $attendanceRate }}%</h3>
                        </div>
                        <div class="fs-1 opacity-50">
                            <i class="bi bi-graph-up"></i>
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
                            <h6 class="card-title mb-0">Total Paid</h6>
                            <h3 class="mb-0">MWK {{ number_format($totalPaid, 2) }}</h3>
                        </div>
                        <div class="fs-1 opacity-50">
                            <i class="bi bi-cash-stack"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-3">
            <div class="card border-0 shadow-sm {{ $balance <= 0 ? 'bg-gradient-success' : 'bg-gradient-warning' }} text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-0">Balance</h6>
                            <h3 class="mb-0">MWK {{ number_format(abs($balance), 2) }}</h3>
                        </div>
                        <div class="fs-1 opacity-50">
                            <i class="bi bi-wallet2"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Financial Details -->
    <div class="row mb-4">
        <div class="col-12 col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">💰 Financial Summary</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <p class="mb-2"><strong>Expected Amount:</strong></p>
                            <p class="mb-2"><strong>Total Paid:</strong></p>
                            <p class="mb-2"><strong>Balance:</strong></p>
                            <p class="mb-0"><strong>Payment Status:</strong></p>
                        </div>
                        <div class="col-6 text-end">
                            <p class="mb-2">MWK {{ number_format($expectedAmount, 2) }}</p>
                            <p class="mb-2">MWK {{ number_format($totalPaid, 2) }}</p>
                            <p class="mb-2 text-{{ $balance <= 0 ? 'success' : 'danger' }}">
                                MWK {{ number_format(abs($balance), 2) }} {{ $balance <= 0 ? '(Credit)' : '(Due)' }}
                            </p>
                            <p class="mb-0">
                                <span class="badge {{ $paymentStatus['status'] === 'paid' ? 'bg-success' : 'bg-warning' }}">
                                    {{ ucfirst($paymentStatus['status']) }} ({{ $paymentStatus['percentage'] }}%)
                                </span>
                            </p>
                        </div>
                    </div>
                    
                    <!-- Payment History -->
                    @if($enrollment->payments->isNotEmpty())
                        <hr>
                        <h6>Payment History</h6>
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($enrollment->payments->sortByDesc('created_at') as $payment)
                                        <tr>
                                            <td>{{ $payment->created_at->format('M d, Y') }}</td>
                                            <td>MWK {{ number_format($payment->amount, 2) }}</td>
                                            <td>
                                                <span class="badge {{ $payment->status === 'approved' ? 'bg-success' : 'bg-warning' }}">
                                                    {{ ucfirst($payment->status) }}
                                                </span>
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

        <!-- Progress Overview -->
        <div class="col-12 col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">📈 Progress Overview</h5>
                </div>
                <div class="card-body">
                    <div class="text-center mb-3">
                        <div class="progress-circle">
                            <div class="progress-circle-inner">
                                <strong>{{ $attendanceRate }}%</strong>
                                <br>
                                <small>Attendance Rate</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row text-center">
                        <div class="col-4">
                            <div class="stat-box">
                                <h4 class="text-success">{{ $enrollment->attendance->where('status', 'present')->count() }}</h4>
                                <small>Present</small>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="stat-box">
                                <h4 class="text-danger">{{ $enrollment->attendance->where('status', 'missed')->count() }}</h4>
                                <small>Missed</small>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="stat-box">
                                <h4 class="text-primary">{{ count($weeklyData) }}</h4>
                                <small>Weeks Active</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Weekly Attendance Details -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">📅 Weekly Attendance Details</h5>
        </div>
        <div class="card-body">
            @if(empty($weeklyData))
                <div class="text-center text-muted py-5">
                    <i class="bi bi-calendar-x fs-1"></i>
                    <h5>No attendance records yet</h5>
                    <p>Start recording attendance for this student.</p>
                    <a href="{{ route('admin.attendance.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i> Record First Attendance
                    </a>
                </div>
            @else
                <div class="accordion" id="weeklyAccordion">
                    @foreach($weeklyData as $week => $weekData)
                        <div class="accordion-item mb-3">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" 
                                        data-bs-toggle="collapse" 
                                        data-bs-target="#week{{ $week }}">
                                    <div class="w-100 d-flex justify-content-between align-items-center">
                                        <div>
                                            <strong>Week {{ $week }}</strong>
                                            <span class="badge bg-success ms-2">{{ $weekData['present_sessions'] }}/{{ $weekData['total_sessions'] }} Present</span>
                                            <span class="badge bg-info ms-1">{{ $weekData['paid_sessions'] }} Paid</span>
                                        </div>
                                        <div class="text-end">
                                            @if($weekData['total_sessions'] > 0)
                                                <small class="text-muted">
                                                    {{ round(($weekData['present_sessions'] / $weekData['total_sessions']) * 100, 1) }}% attendance
                                                </small>
                                            @endif
                                        </div>
                                    </div>
                                </button>
                            </h2>
                            <div id="week{{ $week }}" 
                                 class="accordion-collapse collapse" 
                                 data-bs-parent="#weeklyAccordion">
                                <div class="accordion-body">
                                    <!-- Sessions Table -->
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Session #</th>
                                                    <th>Date</th>
                                                    <th>Status</th>
                                                    <th>Payment</th>
                                                    <th>Reason</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($weekData['sessions'] as $session)
                                                    <tr>
                                                        <td>
                                                            <span class="badge bg-primary">
                                                                Session {{ $session->session_number }}
                                                            </span>
                                                        </td>
                                                        <td>{{ $session->session_date->format('M d, Y') }}</td>
                                                        <td>
                                                            @if($session->status === 'present')
                                                                <span class="badge bg-success">Present</span>
                                                            @else
                                                                <span class="badge bg-danger">Missed</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <span class="badge {{ $session->payment_status === 'paid' ? 'bg-success' : ($session->payment_status === 'partial' ? 'bg-warning' : 'bg-secondary') }}">
                                                                {{ ucfirst($session->payment_status) }}
                                                            </span>
                                                        </td>
                                                        <td>{{ $session->reason ?? '-' }}</td>
                                                        <td>
                                                            <div class="d-flex gap-2">
                                                                <a href="{{ route('admin.attendance.edit', $session->id) }}" 
                                                                   class="btn btn-warning btn-sm">
                                                                    <i class="bi bi-pencil me-1"></i> Edit
                                                                </a>
                                                                <form action="{{ route('admin.attendance.destroy', $session->id) }}" 
                                                                      method="POST" onsubmit="return confirm('Are you sure you want to delete this attendance record?')">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-danger btn-sm">
                                                                        <i class="bi bi-trash me-1"></i> Delete
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    
                                    <!-- Week Summary -->
                                    <div class="mt-3 pt-3 border-top">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h6>Attendance Summary</h6>
                                                <div class="progress" style="height: 20px;">
                                                    <div class="progress-bar bg-success" 
                                                         style="width: {{ ($weekData['present_sessions'] / $weekData['total_sessions']) * 100 }}%">
                                                        Present: {{ $weekData['present_sessions'] }}
                                                    </div>
                                                    <div class="progress-bar bg-danger" 
                                                         style="width: {{ (($weekData['total_sessions'] - $weekData['present_sessions']) / $weekData['total_sessions']) * 100 }}%">
                                                        Missed: {{ $weekData['total_sessions'] - $weekData['present_sessions'] }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <h6>Payment Summary</h6>
                                                <div class="d-flex gap-1 flex-wrap">
                                                    <span class="badge bg-success">Paid: {{ $weekData['paid_sessions'] }}</span>
                                                    <span class="badge bg-secondary">Unpaid: {{ $weekData['total_sessions'] - $weekData['paid_sessions'] }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
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

.progress-circle {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    background: conic-gradient(#4facfe 0deg {{ $attendanceRate * 3.6 }}deg, #e9ecef {{ $attendanceRate * 3.6 }}deg);
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
}

.progress-circle-inner {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    background: white;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}

.stat-box {
    padding: 10px;
}

.stat-box h4 {
    margin-bottom: 0;
    font-weight: bold;
}

.accordion-button:not(.collapsed) {
    background-color: #f8f9fa;
    color: #495057;
}

.accordion-item {
    border-radius: 0.5rem !important;
    overflow: hidden;
}

.card {
    transition: transform 0.2s ease-in-out;
}

.card:hover {
    transform: translateY(-2px);
}

.progress-bar {
    font-size: 0.75rem;
    line-height: 1.2rem;
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
    min-width: 80px;
}

.btn-sm i {
    font-size: 0.875rem;
}

.d-flex.gap-2 .btn-sm {
    min-width: auto;
}
</style>
@endsection
