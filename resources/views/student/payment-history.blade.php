@extends('layouts.app')

@section('title', 'Payment History')

@section('content')
<div class="payment-history-wrapper">
    <div class="container-fluid py-4">
        <!-- Animated Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="page-header">
                    <div class="header-content">
                        <div class="header-left">
                            <div class="header-icon">
                                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <line x1="12" y1="1" x2="12" y2="23"/>
                                    <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
                                </svg>
                            </div>
                            <div class="header-text">
                                <h1 class="page-title">Payment History</h1>
                                <p class="page-subtitle">Track your yoga program payments and account balance</p>
                            </div>
                        </div>
                        @if($enrollment)
                            <div class="header-stats">
                                <div class="stat-card">
                                    <div class="stat-value">MWK {{ number_format($balance, 0) }}</div>
                                    <div class="stat-label">Balance</div>
                                </div>
                                <div class="stat-card">
                                    <div class="stat-value">{{ $paymentStatus }}</div>
                                    <div class="stat-label">Status</div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        @if(!$enrollment)
            <!-- No Enrollment State -->
            <div class="empty-state">
                <div class="empty-icon">
                    <svg width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1">
                        <line x1="12" y1="1" x2="12" y2="23"/>
                        <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
                    </svg>
                </div>
                <h2>No Active Enrollment</h2>
                <p>You need to be enrolled in a program to view payment history.</p>
                <a href="{{ route('student.programs.index') }}" class="btn-primary">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/>
                        <polyline points="17,21 17,13 7,13 7,21"/>
                        <polyline points="7,3 7,8 15,8"/>
                    </svg>
                    Browse Programs
                </a>
            </div>
        @else
            <!-- Main Content Grid -->
            <div class="row">
                <!-- Overview Cards -->
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="overview-card paid-card">
                        <div class="card-icon">
                            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                                <polyline points="22 4 12 14.01 9 11.01"/>
                            </svg>
                        </div>
                        <div class="card-content">
                            <div class="card-number">MWK {{ number_format($totalPaid, 0) }}</div>
                            <div class="card-label">Total Paid</div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="overview-card pending-card">
                        <div class="card-icon">
                            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10"/>
                                <polyline points="12 6 12 12 16 14"/>
                            </svg>
                        </div>
                        <div class="card-content">
                            <div class="card-number">MWK {{ number_format($pendingPayments, 0) }}</div>
                            <div class="card-label">Pending</div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="overview-card expected-card">
                        <div class="card-icon">
                            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
                            </svg>
                        </div>
                        <div class="card-content">
                            <div class="card-number">MWK {{ number_format($expectedAmount, 0) }}</div>
                            <div class="card-label">Expected Total</div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="overview-card balance-card">
                        <div class="card-icon">
                            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/>
                            </svg>
                        </div>
                        <div class="card-content">
                            <div class="card-number">{{ $payments->count() }}</div>
                            <div class="card-label">Transactions</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Status Card -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="status-card">
                        <div class="status-header">
                            <div class="status-info">
                                <h3>Account Status</h3>
                                <div class="status-details">
                                    <span class="status-badge {{ $paymentStatus }}">
                                        @if($paymentStatus == 'paid')
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                                                <polyline points="22 4 12 14.01 9 11.01"/>
                                            </svg>
                                            Fully Paid
                                        @elseif($paymentStatus == 'partial')
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <circle cx="12" cy="12" r="10"/>
                                                <polyline points="12 6 12 12 16 14"/>
                                            </svg>
                                            Partially Paid
                                        @else
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <circle cx="12" cy="12" r="10"/>
                                                <line x1="15" y1="9" x2="9" y2="15"/>
                                                <line x1="9" y1="9" x2="15" y2="15"/>
                                            </svg>
                                            Unpaid
                                        @endif
                                    </span>
                                    <span class="balance-amount">Balance: MWK {{ number_format($balance, 0) }}</span>
                                </div>
                            </div>
                            <div class="status-progress">
                                <div class="progress-label">Payment Progress</div>
                                <div class="progress-bar-container">
                                    <div class="progress-bar paid" style="width: {{ $expectedAmount > 0 ? min(100, ($totalPaid / $expectedAmount) * 100) : 0 }}%"></div>
                                </div>
                                <div class="progress-percentage">{{ $expectedAmount > 0 ? round(($totalPaid / $expectedAmount) * 100, 1) : 0 }}% Complete</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Monthly Breakdown -->
            @if($monthlyPayments && $monthlyPayments->count() > 0)
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="chart-card">
                            <div class="chart-header">
                                <h3>Monthly Payment Breakdown</h3>
                                <div class="chart-legend">
                                    <div class="legend-item">
                                        <div class="legend-color paid"></div>
                                        <span>Amount Paid</span>
                                    </div>
                                </div>
                            </div>
                            <div class="chart-container">
                                <div class="monthly-chart">
                                    @foreach($monthlyPayments as $month => $data)
                                        <div class="month-bar">
                                            <div class="month-info">
                                                <span class="month-label">{{ $data['month'] }}</span>
                                                <span class="month-stats">{{ $data['count'] }} payment{{ $data['count'] > 1 ? 's' : '' }}</span>
                                            </div>
                                            <div class="month-progress">
                                                <div class="progress-bar paid" style="width: {{ $expectedAmount > 0 ? min(100, ($data['total'] / $expectedAmount) * 100) : 0 }}%"></div>
                                            </div>
                                            <div class="month-amount">MWK {{ number_format($data['total'], 0) }}</div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Payment History Table -->
            <div class="row">
                <div class="col-12">
                    <div class="payment-table-card">
                        <div class="card-header">
                            <h3>Payment History</h3>
                            <div class="view-toggle">
                                <button class="toggle-btn active" onclick="showView('recent')">Recent</button>
                                <button class="toggle-btn" onclick="showView('all')">All Payments</button>
                            </div>
                        </div>
                        
                        <!-- Recent View -->
                        <div id="recent-view" class="payment-content">
                            <div class="payment-list">
                                @if($recentPayments && $recentPayments->count() > 0)
                                    @foreach($recentPayments as $payment)
                                        <div class="payment-item {{ $payment->status }}">
                                            <div class="payment-date">
                                                <div class="date-day">{{ \Carbon\Carbon::parse($payment->payment_date)->format('d') }}</div>
                                                <div class="date-month">{{ \Carbon\Carbon::parse($payment->payment_date)->format('M') }}</div>
                                            </div>
                                            <div class="payment-details">
                                                <div class="payment-info">
                                                    <h4>Payment #{{ $payment->id }}</h4>
                                                    <p>{{ \Carbon\Carbon::parse($payment->payment_date)->format('l, F j, Y') }}</p>
                                                    <div class="payment-frequency">
                                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                            <path d="M12 2v20M7 7h10M7 12h10M7 17h10"/>
                                                        </svg>
                                                        <span>{{ ucfirst($payment->payment_frequency ?? 'one_time') }} Payment</span>
                                                    </div>
                                                    @if($payment->notes)
                                                        <div class="payment-notes">
                                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                                                <polyline points="14,2 14,8 20,8"/>
                                                                <line x1="16" y1="13" x2="8" y2="13"/>
                                                                <line x1="16" y1="17" x2="8" y2="17"/>
                                                            </svg>
                                                            {{ $payment->notes }}
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="payment-status">
                                                    <div class="status-badge {{ $payment->status }}">
                                                        @if($payment->status == 'approved')
                                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                                                                <polyline points="22 4 12 14.01 9 11.01"/>
                                                            </svg>
                                                            Approved
                                                        @elseif($payment->status == 'pending')
                                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                                <circle cx="12" cy="12" r="10"/>
                                                                <polyline points="12 6 12 12 16 14"/>
                                                            </svg>
                                                            Pending
                                                        @else
                                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                                <circle cx="12" cy="12" r="10"/>
                                                                <line x1="15" y1="9" x2="9" y2="15"/>
                                                                <line x1="9" y1="9" x2="15" y2="15"/>
                                                            </svg>
                                                            Rejected
                                                        @endif
                                                    </div>
                                                    <div class="payment-amount">MWK {{ number_format($payment->amount_paid, 0) }}</div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="empty-state">
                                        <div class="empty-icon">💳</div>
                                        <h6>No payment records found</h6>
                                        <p>Your payment history will appear here once you make payments.</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- All Payments View -->
                        <div id="all-view" class="payment-content" style="display: none;">
                            <div class="payment-table-container">
                                <table class="payment-table">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Payment ID</th>
                                            <th>Amount</th>
                                            <th>Frequency</th>
                                            <th>Status</th>
                                            <th>Notes</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($payments && $payments->count() > 0)
                                            @foreach($payments as $payment)
                                                <tr class="payment-row {{ $payment->status }}">
                                                    <td>{{ \Carbon\Carbon::parse($payment->payment_date)->format('M d, Y') }}</td>
                                                    <td>#{{ $payment->id }}</td>
                                                    <td class="amount-cell">MWK {{ number_format($payment->amount_paid, 0) }}</td>
                                                    <td>
                                                        <span class="frequency-badge">
                                                            {{ ucfirst($payment->payment_frequency ?? 'one_time') }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span class="status-badge {{ $payment->status }}">
                                                            {{ ucfirst($payment->status) }}
                                                        </span>
                                                    </td>
                                                    <td>{{ $payment->notes ?? '-' }}</td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="6" class="text-center">
                                                    <div class="empty-state">
                                                        <p>No payment records found</p>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Tips -->
            <div class="row">
                <div class="col-12">
                    <div class="tips-card">
                        <div class="tips-content">
                            <div class="tips-icon">
                                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="12" cy="12" r="10"/>
                                    <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/>
                                    <line x1="12" y1="17" x2="12.01" y2="17"/>
                                </svg>
                            </div>
                            <div class="tips-text">
                                <h3>Payment Information</h3>
                                <p>
                                    @if($paymentStatus == 'paid')
                                        Congratulations! Your account is fully paid. Keep up the great work with your yoga journey!
                                    @elseif($paymentStatus == 'partial')
                                        You're making good progress! Your current balance is MWK {{ number_format($balance, 0) }}. Consider setting up regular payments to stay on track.
                                    @else
                                        Your account shows a balance of MWK {{ number_format($balance, 0) }}. Regular payments help you stay focused on your yoga goals without financial interruptions.
                                    @endif
                                </p>
                                <div class="payment-tips">
                                    <div class="tip-item">
                                        Monthly Rate: MWK 120,000
                                    </div>
                                    <div class="tip-item">
                                        Program Duration: {{ $enrollment->program->duration_weeks ?? 12 }} weeks
                                    </div>
                                    <div class="tip-item">
                                        Payment Options: Daily (10,000), Weekly (30,000), Monthly (120,000)
                                    </div>
                                    @if($payments && $payments->count() > 0)
                                        <div class="tip-item">
                                            <strong>Payment Methods Used:</strong>
                                            @php
                                                $paymentMethods = $payments->pluck('payment_method')->unique();
                                            @endphp
                                            @foreach($paymentMethods as $method)
                                                <span class="payment-method-badge">{{ ucfirst($method) }}</span>
                                            @endforeach
                                        </div>
                                        <div class="tip-item">
                                            <strong>Payment Frequencies:</strong>
                                            @php
                                                $paymentFrequencies = $payments->pluck('payment_frequency')->unique();
                                            @endphp
                                            @foreach($paymentFrequencies as $frequency)
                                                <span class="payment-frequency-badge">{{ ucfirst(str_replace('_', ' ', $frequency)) }}</span>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Professional Styles -->
<style>
:root {
    --bg-primary: #0f0f0f;
    --bg-secondary: #1a1a1a;
    --bg-tertiary: #2a2a2a;
    --text-primary: #ffffff;
    --text-secondary: #b8b8b8;
    --text-muted: #888888;
    --accent-lavender: #9b59b6;
    --accent-lavender-light: #c39bd3;
    --accent-lavender-dark: #8e44ad;
    --success-color: #10b981;
    --warning-color: #f59e0b;
    --danger-color: #ef4444;
    --border-color: #3a3a3a;
}

.payment-history-wrapper {
    background: linear-gradient(135deg, var(--bg-primary) 0%, #1a1a2e 100%);
    min-height: 100vh;
    color: var(--text-primary);
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
}

/* Animated Header */
.page-header {
    background: linear-gradient(135deg, var(--accent-lavender) 0%, var(--accent-lavender-dark) 100%);
    border-radius: 20px;
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: 0 20px 40px rgba(155, 89, 182, 0.3);
    position: relative;
    overflow: hidden;
}

.page-header::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -10%;
    width: 300px;
    height: 300px;
    background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
    border-radius: 50%;
    animation: float 6s ease-in-out infinite;
}

@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-20px); }
}

.header-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
    position: relative;
    z-index: 1;
}

.header-left {
    display: flex;
    align-items: center;
    gap: 1.5rem;
}

.header-icon {
    background: rgba(255, 255, 255, 0.2);
    border-radius: 16px;
    padding: 1rem;
    display: flex;
    align-items: center;
    justify-content: center;
    backdrop-filter: blur(10px);
}

.header-icon svg {
    stroke: white;
}

.page-title {
    font-size: 2.5rem;
    font-weight: 800;
    margin-bottom: 0.5rem;
    background: linear-gradient(135deg, #ffffff 0%, rgba(255,255,255,0.8) 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.page-subtitle {
    font-size: 1.1rem;
    color: rgba(255, 255, 255, 0.9);
    margin-bottom: 0;
}

.header-stats {
    display: flex;
    gap: 1rem;
}

.stat-card {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    border-radius: 16px;
    padding: 1.5rem;
    text-align: center;
    min-width: 120px;
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.stat-value {
    font-size: 1.5rem;
    font-weight: 700;
    color: white;
    margin-bottom: 0.25rem;
}

.stat-label {
    font-size: 0.875rem;
    color: rgba(255, 255, 255, 0.8);
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

/* Overview Cards */
.overview-card {
    background: var(--bg-secondary);
    border-radius: 20px;
    padding: 2rem;
    border: 1px solid var(--border-color);
    display: flex;
    align-items: center;
    gap: 1.5rem;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.overview-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, var(--accent-lavender), var(--accent-lavender-light));
}

.overview-card.paid-card::before {
    background: linear-gradient(90deg, var(--success-color), #34d399);
}

.overview-card.pending-card::before {
    background: linear-gradient(90deg, var(--warning-color), #fbbf24);
}

.overview-card.expected-card::before {
    background: linear-gradient(90deg, var(--accent-lavender), var(--accent-lavender-light));
}

.overview-card.balance-card::before {
    background: linear-gradient(90deg, var(--danger-color), #f87171);
}

.overview-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3);
}

.card-icon {
    background: var(--bg-tertiary);
    border-radius: 16px;
    padding: 1rem;
    display: flex;
    align-items: center;
    justify-content: center;
}

.paid-card .card-icon {
    color: var(--success-color);
}

.pending-card .card-icon {
    color: var(--warning-color);
}

.expected-card .card-icon {
    color: var(--accent-lavender);
}

.balance-card .card-icon {
    color: var(--danger-color);
}

.card-number {
    font-size: 1.5rem;
    font-weight: 800;
    color: var(--text-primary);
    margin-bottom: 0.25rem;
}

.card-label {
    font-size: 0.875rem;
    color: var(--text-secondary);
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

/* Status Card */
.status-card {
    background: var(--bg-secondary);
    border-radius: 20px;
    padding: 2rem;
    border: 1px solid var(--border-color);
}

.status-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
}

.status-info h3 {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--text-primary);
    margin-bottom: 0.5rem;
}

.status-details {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.status-badge.paid {
    background: rgba(16, 185, 129, 0.2);
    color: var(--success-color);
}

.status-badge.partial {
    background: rgba(245, 158, 11, 0.2);
    color: var(--warning-color);
}

.status-badge.unpaid {
    background: rgba(239, 68, 68, 0.2);
    color: var(--danger-color);
}

.balance-amount {
    font-size: 1.1rem;
    font-weight: 600;
    color: var(--text-primary);
}

.status-progress {
    max-width: 300px;
}

.progress-label {
    font-size: 0.875rem;
    color: var(--text-secondary);
    margin-bottom: 0.5rem;
}

.progress-bar-container {
    height: 8px;
    background: var(--bg-tertiary);
    border-radius: 4px;
    overflow: hidden;
    margin-bottom: 0.5rem;
}

.progress-bar.paid {
    height: 100%;
    background: linear-gradient(90deg, var(--success-color), #34d399);
    transition: width 0.3s ease;
}

.progress-percentage {
    font-size: 0.875rem;
    color: var(--text-secondary);
    text-align: right;
}

/* Payment Badges */
.payment-method-badge, .payment-frequency-badge {
    display: inline-block;
    padding: 0.25rem 0.75rem;
    margin: 0.25rem 0.25rem 0.25rem 0;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: capitalize;
}

.payment-method-badge {
    background: var(--accent-lavender);
    color: white;
    border: 1px solid var(--accent-lavender);
}

.payment-frequency-badge {
    background: var(--success-color);
    color: white;
    border: 1px solid var(--success-color);
}

/* Chart Card */
.chart-card {
    background: var(--bg-secondary);
    border-radius: 20px;
    padding: 2rem;
    border: 1px solid var(--border-color);
}

.chart-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
}

.chart-header h3 {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--text-primary);
}

.chart-legend {
    display: flex;
    gap: 1.5rem;
}

.legend-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.875rem;
    color: var(--text-secondary);
}

.legend-color.paid {
    width: 12px;
    height: 12px;
    border-radius: 3px;
    background: var(--success-color);
}

.monthly-chart {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.month-bar {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.month-info {
    min-width: 150px;
    display: flex;
    flex-direction: column;
}

.month-label {
    font-weight: 600;
    color: var(--text-primary);
}

.month-stats {
    font-size: 0.875rem;
    color: var(--text-secondary);
}

.month-progress {
    flex: 1;
    height: 24px;
    background: var(--bg-tertiary);
    border-radius: 12px;
    overflow: hidden;
}

.month-amount {
    font-weight: 600;
    color: var(--success-color);
    min-width: 100px;
    text-align: right;
}

/* Payment Table Card */
.payment-table-card {
    background: var(--bg-secondary);
    border-radius: 20px;
    padding: 2rem;
    border: 1px solid var(--border-color);
}

.card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
}

.card-header h3 {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--text-primary);
}

.view-toggle {
    display: flex;
    background: var(--bg-tertiary);
    border-radius: 12px;
    padding: 0.25rem;
}

.toggle-btn {
    padding: 0.5rem 1rem;
    border: none;
    background: transparent;
    color: var(--text-secondary);
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.3s ease;
    font-weight: 600;
}

.toggle-btn.active {
    background: var(--accent-lavender);
    color: white;
}

/* Payment List */
.payment-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.payment-item {
    display: flex;
    align-items: center;
    gap: 1.5rem;
    padding: 1.5rem;
    background: var(--bg-tertiary);
    border-radius: 16px;
    border-left: 4px solid transparent;
    transition: all 0.3s ease;
}

.payment-item.approved {
    border-left-color: var(--success-color);
}

.payment-item.pending {
    border-left-color: var(--warning-color);
}

.payment-item.rejected {
    border-left-color: var(--danger-color);
}

.payment-item:hover {
    transform: translateX(5px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
}

.payment-date {
    background: var(--bg-secondary);
    border-radius: 12px;
    padding: 1rem;
    text-align: center;
    min-width: 80px;
}

.date-day {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--accent-lavender);
}

.date-month {
    font-size: 0.875rem;
    color: var(--text-secondary);
    text-transform: uppercase;
}

.payment-details {
    flex: 1;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.payment-info h4 {
    font-size: 1.1rem;
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 0.25rem;
}

.payment-info p {
    font-size: 0.875rem;
    color: var(--text-secondary);
    margin-bottom: 0.5rem;
}

.payment-notes {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.875rem;
    color: var(--text-secondary);
    background: var(--bg-secondary);
    padding: 0.25rem 0.75rem;
    border-radius: 8px;
}

.payment-frequency {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.875rem;
    color: var(--accent-lavender);
    background: rgba(155, 89, 182, 0.1);
    padding: 0.25rem 0.75rem;
    border-radius: 8px;
    margin-bottom: 0.5rem;
}

.frequency-badge {
    display: inline-block;
    padding: 0.25rem 0.75rem;
    border-radius: 8px;
    font-size: 0.75rem;
    font-weight: 600;
    background: rgba(155, 89, 182, 0.2);
    color: var(--accent-lavender);
}

.payment-status {
    text-align: right;
}

.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    border-radius: 12px;
    font-size: 0.875rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.payment-amount {
    font-size: 1.1rem;
    font-weight: 700;
    color: var(--accent-lavender);
}

/* Payment Table */
.payment-table-container {
    overflow-x: auto;
}

.payment-table {
    width: 100%;
    border-collapse: collapse;
    background: var(--bg-tertiary);
    border-radius: 12px;
    overflow: hidden;
}

.payment-table th {
    background: var(--bg-secondary);
    padding: 1rem;
    text-align: left;
    font-weight: 600;
    color: var(--text-primary);
    border-bottom: 1px solid var(--border-color);
}

.payment-table td {
    padding: 1rem;
    border-bottom: 1px solid var(--border-color);
    color: var(--text-secondary);
}

.payment-row:hover {
    background: var(--bg-secondary);
}

.amount-cell {
    font-weight: 600;
    color: var(--accent-lavender);
}

/* Tips Card */
.tips-card {
    background: linear-gradient(135deg, var(--accent-lavender) 0%, var(--accent-lavender-dark) 100%);
    border-radius: 20px;
    padding: 2rem;
    border: 1px solid rgba(255, 255, 255, 0.1);
}

.tips-content {
    display: flex;
    align-items: flex-start;
    gap: 2rem;
}

.tips-icon {
    background: rgba(255, 255, 255, 0.2);
    border-radius: 16px;
    padding: 1.5rem;
    display: flex;
    align-items: center;
    justify-content: center;
    backdrop-filter: blur(10px);
}

.tips-icon svg {
    stroke: white;
}

.tips-text h3 {
    font-size: 1.5rem;
    font-weight: 700;
    color: white;
    margin-bottom: 1rem;
}

.tips-text p {
    color: rgba(255, 255, 255, 0.9);
    margin-bottom: 1.5rem;
    line-height: 1.6;
}

.payment-tips {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.tip-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    color: rgba(255, 255, 255, 0.9);
    font-size: 0.875rem;
}

/* Empty State */
.empty-state {
    background: var(--bg-secondary);
    border-radius: 20px;
    padding: 4rem 2rem;
    text-align: center;
    border: 1px solid var(--border-color);
}

.empty-icon {
    font-size: 3rem;
    margin-bottom: 2rem;
    opacity: 0.5;
}

.empty-icon svg {
    stroke: var(--accent-lavender);
}

.empty-state h2 {
    font-size: 2rem;
    font-weight: 700;
    color: var(--text-primary);
    margin-bottom: 1rem;
}

.empty-state h6 {
    color: var(--text-secondary);
    margin-bottom: 0.5rem;
}

.empty-state p {
    font-size: 1.1rem;
    color: var(--text-secondary);
    margin-bottom: 2rem;
}

.btn-primary {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    background: var(--accent-lavender);
    color: white;
    padding: 1rem 2rem;
    border-radius: 12px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    background: var(--accent-lavender-dark);
    transform: translateY(-2px);
    box-shadow: 0 10px 20px rgba(155, 89, 182, 0.3);
}

/* Responsive */
@media (max-width: 768px) {
    .header-content {
        flex-direction: column;
        gap: 1.5rem;
        text-align: center;
    }
    
    .header-left {
        flex-direction: column;
        gap: 1rem;
    }
    
    .page-title {
        font-size: 2rem;
    }
    
    .status-header {
        flex-direction: column;
        gap: 1rem;
        text-align: center;
    }
    
    .status-progress {
        max-width: 100%;
    }
    
    .payment-item {
        flex-direction: column;
        text-align: center;
        gap: 1rem;
    }
    
    .payment-details {
        flex-direction: column;
        gap: 1rem;
        text-align: center;
    }
    
    .payment-status {
        text-align: center;
    }
    
    .tips-content {
        flex-direction: column;
        text-align: center;
        gap: 1rem;
    }
    
    .monthly-chart {
        overflow-x: auto;
    }
    
    .month-bar {
        min-width: 350px;
    }
}
</style>

<!-- JavaScript -->
<script>
function showView(viewType) {
    const recentView = document.getElementById('recent-view');
    const allView = document.getElementById('all-view');
    const toggleBtns = document.querySelectorAll('.toggle-btn');
    
    toggleBtns.forEach(btn => btn.classList.remove('active'));
    
    if (viewType === 'recent') {
        recentView.style.display = 'block';
        allView.style.display = 'none';
        toggleBtns[0].classList.add('active');
    } else {
        recentView.style.display = 'none';
        allView.style.display = 'block';
        toggleBtns[1].classList.add('active');
    }
}

// Add some interactive animations
document.addEventListener('DOMContentLoaded', function() {
    // Animate overview cards on scroll
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, { threshold: 0.1 });
    
    document.querySelectorAll('.overview-card').forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        card.style.transition = 'all 0.6s ease';
        observer.observe(card);
    });
    
    // Animate payment items
    document.querySelectorAll('.payment-item').forEach((item, index) => {
        item.style.opacity = '0';
        item.style.transform = 'translateX(-20px)';
        item.style.transition = 'all 0.5s ease';
        setTimeout(() => {
            item.style.opacity = '1';
            item.style.transform = 'translateX(0)';
        }, index * 100);
    });
});
</script>
@endsection
