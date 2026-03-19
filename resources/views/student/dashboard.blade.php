@extends('layouts.app')

@section('title', 'Student Dashboard')

@section('content')
<div class="dashboard-wrapper">
    <div class="container-fluid py-4">
        <!-- Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="welcome-card">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h1 class="welcome-title">
                                Welcome back, {{ auth()->user()->name }} 🧘‍♀️
                            </h1>
                            <p class="welcome-subtitle">
                                Your yoga journey continues. Track your progress and stay motivated.
                            </p>
                        </div>
                        <div class="col-md-4 text-md-end">
                            <div class="current-streak" onclick="showStreakDetails()" style="cursor: pointer;">
                                <div class="streak-icon">🔥</div>
                                <div class="streak-info">
                                    <div class="streak-number">{{ $currentStreak ?? 0 }}</div>
                                    <div class="streak-label">Day Streak</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="row g-4 mb-4">
            <div class="col-md-3">
                <div class="stat-card attendance-card">
                    <div class="stat-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                            <circle cx="9" cy="7" r="4"/>
                            <path d="M22 21v-2a4 4 0 0 0-3-3.87"/>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                        </svg>
                    </div>
                    <div class="stat-content">
                        <div class="stat-number">{{ $attendanceStats['present'] ?? 0 }}</div>
                        <div class="stat-label">Sessions Attended</div>
                        <div class="stat-detail">{{ $attendanceStats['total'] ?? 0 }} Total</div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="stat-card progress-card">
                    <div class="stat-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M22 12h-4l-3 9L9 3l-3 9H2"/>
                        </svg>
                    </div>
                    <div class="stat-content">
                        <div class="stat-number">{{ $progressPercentage }}%</div>
                        <div class="stat-label">Program Progress</div>
                        <div class="stat-detail">Week {{ $currentWeek ?? 1 }}/12</div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="stat-card payment-card">
                    <div class="stat-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="12" y1="1" x2="12" y2="23"/>
                            <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
                        </svg>
                    </div>
                    <div class="stat-content">
                        <div class="stat-number">MWK {{ number_format($paymentSummary['balance'] ?? 0, 0) }}</div>
                        <div class="stat-label">Account Balance</div>
                        <div class="stat-detail">{{ $paymentSummary['status'] ?? 'Pending' }}</div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="stat-card achievement-card">
                    <div class="stat-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                        </svg>
                    </div>
                    <div class="stat-content">
                        <div class="stat-number">{{ $achievementCount ?? 0 }}</div>
                        <div class="stat-label">Achievements</div>
                        <div class="stat-detail">{{ $achievementCount ?? 0 }} Earned</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="row g-4">
            <!-- Attendance Details -->
            <div class="col-lg-8">
                <div class="content-card">
                    <div class="card-header-custom">
                        <h5 class="card-title">
                            <i class="bi bi-calendar-check me-2"></i>Recent Attendance
                        </h5>
                        <a href="{{ route('student.attendance') }}" class="btn-view-all">View All</a>
                    </div>
                    <div class="card-body-custom">
                        @if($recentAttendance && $recentAttendance->count() > 0)
                            <div class="attendance-timeline">
                                @foreach($recentAttendance->take(5) as $attendance)
                                    <div class="attendance-item">
                                        <div class="attendance-date">
                                            {{ \Carbon\Carbon::parse($attendance->session_date)->format('M d') }}
                                        </div>
                                        <div class="attendance-details">
                                            <div class="attendance-status {{ $attendance->status === 'present' ? 'present' : 'missed' }}">
                                                {{ ucfirst($attendance->status) }}
                                            </div>
                                            <div class="attendance-info">
                                                Week {{ $attendance->week_number ?? 1 }}, Session {{ $attendance->session_number ?? 1 }}
                                            </div>
                                        </div>
                                        <div class="attendance-payment">
                                            <span class="payment-badge {{ $attendance->payment_status ?? 'unpaid' }}">
                                                {{ ucfirst($attendance->payment_status ?? 'unpaid') }}
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="empty-state">
                                <div class="empty-icon">📅</div>
                                <h6>No attendance records yet</h6>
                                <p>Your attendance history will appear here once you start attending classes.</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Weekly Focus -->
                <div class="content-card">
                    <div class="card-header-custom">
                        <h5 class="card-title">
                            <i class="bi bi-bullseye me-2"></i>This Week's Focus
                        </h5>
                    </div>
                    <div class="card-body-custom">
                        @if($weeklyTarget)
                            <div class="focus-content">
                                <div class="focus-title">{{ $weeklyTarget->focus_area }}</div>
                                <div class="focus-description">{{ $weeklyTarget->description }}</div>
                                <div class="focus-progress">
                                    <div class="progress-label">Progress this week</div>
                                    <div class="progress">
                                        <div class="progress-bar-lavender" style="width: 65%"></div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="empty-state">
                                <div class="empty-icon">🎯</div>
                                <h6>Focus guidance coming soon</h6>
                                <p>Your weekly focus areas will be updated by your instructor.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Sidebar Content -->
            <div class="col-lg-4">
                <!-- Payment Summary -->
                <div class="content-card">
                    <div class="card-header-custom">
                        <h5 class="card-title">
                            <i class="bi bi-credit-card me-2"></i>Payment Summary
                        </h5>
                        <a href="#" class="btn-view-all">History</a>
                    </div>
                    <div class="card-body-custom">
                        <div class="payment-overview">
                            <div class="payment-item">
                                <div class="payment-label">Expected Amount</div>
                                <div class="payment-value">MWK {{ number_format($paymentSummary['expected'] ?? 0, 0) }}</div>
                            </div>
                            <div class="payment-item">
                                <div class="payment-label">Amount Paid</div>
                                <div class="payment-value paid">MWK {{ number_format($paymentSummary['paid'] ?? 0, 0) }}</div>
                            </div>
                            <div class="payment-item">
                                <div class="payment-label">Remaining Balance</div>
                                <div class="payment-value {{ ($paymentSummary['balance'] ?? 0) > 0 ? 'due' : 'clear' }}">
                                    MWK {{ number_format(abs($paymentSummary['balance'] ?? 0), 0) }}
                                </div>
                            </div>
                        </div>

                        @if($recentPayments && $recentPayments->count() > 0)
                            <div class="recent-payments">
                                <h6>Recent Payments</h6>
                                @foreach($recentPayments->take(3) as $payment)
                                    <div class="payment-record">
                                        <div class="payment-amount">MWK {{ number_format($payment->amount_paid, 0) }}</div>
                                        <div class="payment-date">{{ \Carbon\Carbon::parse($payment->payment_date)->format('M d') }}</div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Pose to Practice -->
                <div class="content-card">
                    <div class="card-header-custom">
                        <h5 class="card-title">
                            <i class="bi bi-person-arms-up me-2"></i>Pose to Practice
                        </h5>
                    </div>
                    <div class="card-body-custom">
                        @if($weeklyPose)
                            <div class="pose-content">
                                <div class="pose-name">{{ $weeklyPose->pose_name }}</div>
                                <div class="pose-details">
                                    <div class="pose-hold-time">
                                        <i class="bi bi-clock me-1"></i>
                                        Hold for {{ $weeklyPose->hold_time_seconds }} seconds
                                    </div>
                                    @if($weeklyPose->notes)
                                        <div class="pose-notes">
                                            <i class="bi bi-chat-quote me-1"></i>
                                            {{ $weeklyPose->notes }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @else
                            <div class="empty-state">
                                <div class="empty-icon">🧘</div>
                                <h6>Pose instructions coming soon</h6>
                                <p>Your weekly poses will be updated by your instructor.</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Best Moment -->
                <div class="content-card">
                    <div class="card-header-custom">
                        <h5 class="card-title">
                            <i class="bi bi-camera me-2"></i>Best Moment
                        </h5>
                    </div>
                    <div class="card-body-custom">
                        @if($bestMedia)
                            <div class="moment-content">
                                <img src="{{ asset('storage/'.$bestMedia->file_path) }}" 
                                     class="moment-image" 
                                     alt="Weekly highlight">
                                @if($bestMedia->caption)
                                    <p class="moment-caption">{{ $bestMedia->caption }}</p>
                                @endif
                            </div>
                        @else
                            <div class="empty-state">
                                <div class="empty-icon">📸</div>
                                <h6>Your highlight will appear here</h6>
                                <p>Share your best yoga moments!</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Streak Details Modal -->
<div id="streakModal" class="streak-modal" style="display: none;">
    <div class="streak-modal-content">
        <div class="streak-modal-header">
            <h4>🔥 Your Streak Details</h4>
            <button class="close-btn" onclick="closeStreakModal()">&times;</button>
        </div>
        <div class="streak-modal-body">
            <div class="streak-stats">
                <div class="streak-stat-item">
                    <div class="streak-stat-value" id="currentStreakValue">0</div>
                    <div class="streak-stat-label">Current Streak</div>
                </div>
                <div class="streak-stat-item">
                    <div class="streak-stat-value" id="longestStreakValue">0</div>
                    <div class="streak-stat-label">Longest Streak</div>
                </div>
                <div class="streak-stat-item">
                    <div class="streak-stat-value" id="totalDaysValue">0</div>
                    <div class="streak-stat-label">Total Days</div>
                </div>
            </div>
            
            <div class="streak-periods">
                <div class="streak-period">
                    <div class="period-label">This Week</div>
                    <div class="period-value" id="thisWeekValue">0 days</div>
                </div>
                <div class="streak-period">
                    <div class="period-label">This Month</div>
                    <div class="period-value" id="thisMonthValue">0 days</div>
                </div>
            </div>
            
            <div class="recent-activity">
                <h5>Recent Activity (Last 10 Days)</h5>
                <div class="activity-grid" id="activityGrid">
                    <!-- Activity will be populated by JavaScript -->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Custom Styles -->
<style>
:root {
    --bg-primary: #1a1a1a;
    --bg-secondary: #2d2d2d;
    --bg-tertiary: #3a3a3a;
    --text-primary: #ffffff;
    --text-secondary: #b8b8b8;
    --text-muted: #888888;
    --accent-lavender: #9b59b6;
    --accent-lavender-dark: #8e44ad;
    --accent-lavender-light: #c39bd3;
    --border-color: #4a4a4a;
}

.dashboard-wrapper {
    background: var(--bg-primary);
    min-height: 100vh;
    color: var(--text-primary);
}

/* Welcome Card */
.welcome-card {
    background: linear-gradient(135deg, var(--accent-lavender) 0%, var(--accent-lavender-dark) 100%);
    border-radius: 16px;
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: 0 8px 32px rgba(155, 89, 182, 0.2);
}

.welcome-title {
    font-size: 2rem;
    font-weight: 700;
    color: var(--text-primary);
    margin-bottom: 0.5rem;
}

.welcome-subtitle {
    font-size: 1.1rem;
    color: rgba(255, 255, 255, 0.9);
    margin-bottom: 0;
}

.current-streak {
    display: flex;
    align-items: center;
    gap: 1rem;
    background: rgba(255, 255, 255, 0.1);
    padding: 1rem 1.5rem;
    border-radius: 12px;
    backdrop-filter: blur(10px);
    transition: all 0.3s ease;
}

.current-streak:hover {
    background: rgba(255, 255, 255, 0.15);
    transform: translateY(-2px);
}

.streak-icon {
    font-size: 2rem;
}

.streak-number {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--text-primary);
}

.streak-label {
    font-size: 0.875rem;
    color: rgba(255, 255, 255, 0.8);
}

/* Stat Cards */
.stat-card {
    background: var(--bg-secondary);
    border: 1px solid var(--border-color);
    border-radius: 16px;
    padding: 1.5rem;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.stat-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
}

.stat-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: linear-gradient(90deg, var(--accent-lavender), var(--accent-lavender-dark));
}

.stat-icon {
    width: 48px;
    height: 48px;
    background: linear-gradient(135deg, var(--accent-lavender), var(--accent-lavender-dark));
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    margin-bottom: 1rem;
}

.stat-number {
    font-size: 1.75rem;
    font-weight: 700;
    color: var(--text-primary);
    margin-bottom: 0.25rem;
}

.stat-label {
    font-size: 0.875rem;
    color: var(--text-secondary);
    margin-bottom: 0.25rem;
}

.stat-detail {
    font-size: 0.75rem;
    color: var(--text-muted);
}

/* Content Cards */
.content-card {
    background: var(--bg-secondary);
    border: 1px solid var(--border-color);
    border-radius: 16px;
    margin-bottom: 1.5rem;
    overflow: hidden;
}

.card-header-custom {
    padding: 1.5rem;
    border-bottom: 1px solid var(--border-color);
    display: flex;
    justify-content: between;
    align-items: center;
}

.card-title {
    font-size: 1.1rem;
    font-weight: 600;
    color: var(--text-primary);
    margin: 0;
}

.btn-view-all {
    color: var(--accent-lavender);
    text-decoration: none;
    font-size: 0.875rem;
    font-weight: 500;
}

.btn-view-all:hover {
    color: var(--accent-lavender-light);
}

.card-body-custom {
    padding: 1.5rem;
}

/* Attendance Timeline */
.attendance-timeline {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.attendance-item {
    display: flex;
    align-items: center;
    padding: 1rem;
    background: var(--bg-tertiary);
    border-radius: 12px;
    border: 1px solid var(--border-color);
}

.attendance-date {
    font-weight: 600;
    color: var(--accent-lavender);
    min-width: 60px;
}

.attendance-details {
    flex: 1;
    margin-left: 1rem;
}

.attendance-status {
    font-weight: 600;
    font-size: 0.875rem;
    margin-bottom: 0.25rem;
}

.attendance-status.present {
    color: #10b981;
}

.attendance-status.missed {
    color: #ef4444;
}

.attendance-info {
    font-size: 0.75rem;
    color: var(--text-muted);
}

.attendance-payment {
    margin-left: auto;
}

.payment-badge {
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 500;
}

.payment-badge.paid {
    background: rgba(16, 185, 129, 0.2);
    color: #10b981;
}

.payment-badge.unpaid {
    background: rgba(239, 68, 68, 0.2);
    color: #ef4444;
}

.payment-badge.partial {
    background: rgba(251, 191, 36, 0.2);
    color: #f59e0b;
}

/* Payment Overview */
.payment-overview {
    margin-bottom: 1.5rem;
}

.payment-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.75rem 0;
    border-bottom: 1px solid var(--border-color);
}

.payment-item:last-child {
    border-bottom: none;
}

.payment-label {
    font-size: 0.875rem;
    color: var(--text-secondary);
}

.payment-value {
    font-weight: 600;
    color: var(--text-primary);
}

.payment-value.paid {
    color: #10b981;
}

.payment-value.due {
    color: #ef4444;
}

.payment-value.clear {
    color: #10b981;
}

/* Empty States */
.empty-state {
    text-align: center;
    padding: 2rem;
    color: var(--text-muted);
}

.empty-icon {
    font-size: 3rem;
    margin-bottom: 1rem;
    opacity: 0.5;
}

.empty-state h6 {
    color: var(--text-secondary);
    margin-bottom: 0.5rem;
}

.empty-state p {
    font-size: 0.875rem;
    margin-bottom: 0;
}

/* Focus Content */
.focus-content {
    text-align: center;
}

.focus-title {
    font-size: 1.25rem;
    font-weight: 600;
    color: var(--accent-lavender);
    margin-bottom: 1rem;
}

.focus-description {
    color: var(--text-secondary);
    margin-bottom: 1.5rem;
}

.focus-progress {
    text-align: left;
}

.progress-label {
    font-size: 0.875rem;
    color: var(--text-secondary);
    margin-bottom: 0.5rem;
}

.progress {
    height: 8px;
    background: var(--bg-tertiary);
    border-radius: 4px;
    overflow: hidden;
}

.progress-bar-lavender {
    height: 100%;
    background: linear-gradient(90deg, var(--accent-lavender), var(--accent-lavender-dark));
    transition: width 0.3s ease;
}

/* Pose Content */
.pose-name {
    font-size: 1rem;
    font-weight: 600;
    color: var(--accent-lavender);
    margin-bottom: 1rem;
    text-align: center;
}

.pose-details {
    text-align: center;
}

.pose-hold-time,
.pose-notes {
    font-size: 0.875rem;
    color: var(--text-secondary);
    margin-bottom: 0.5rem;
}

/* Moment Content */
.moment-image {
    width: 100%;
    border-radius: 12px;
    margin-bottom: 1rem;
}

.moment-caption {
    font-style: italic;
    color: var(--text-secondary);
    text-align: center;
    margin-bottom: 0;
}

/* Recent Payments */
.recent-payments h6 {
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--text-secondary);
    margin-bottom: 1rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.payment-record {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.5rem 0;
    border-bottom: 1px solid var(--border-color);
}

.payment-record:last-child {
    border-bottom: none;
}

.payment-amount {
    font-weight: 600;
    color: var(--text-primary);
}

.payment-date {
    font-size: 0.875rem;
    color: var(--text-muted);
}

/* Mobile Responsive */
@media (max-width: 768px) {
    .stats-grid {
        grid-template-columns: 1fr;
        gap: 1rem;
    }
    
    .content-card {
        margin-bottom: 1.5rem;
    }
    
    .card-header-custom {
        padding: 1rem;
    }
    
    .card-body-custom {
        padding: 1rem;
    }
    
    .attendance-timeline {
        gap: 0.75rem;
    }
    
    .attendance-item {
        padding: 0.75rem;
    }
    
    .payment-records {
        gap: 0.75rem;
    }
    
    .payment-record {
        padding: 0.75rem;
    }
    
    .pose-card {
        padding: 1rem;
    }
    
    .moment-card {
        padding: 1rem;
    }
    
    .progress-label {
        font-size: 0.75rem;
    }
    
    .pose-name {
        font-size: 1rem;
    }
}

/* Streak Modal Styles */
.streak-modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.7);
    z-index: 10000;
    display: flex;
    align-items: center;
    justify-content: center;
}

.streak-modal-content {
    background: var(--bg-secondary);
    border-radius: 16px;
    width: 90%;
    max-width: 600px;
    max-height: 80vh;
    overflow: hidden;
    border: 1px solid var(--border-color);
}

.streak-modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1.5rem;
    border-bottom: 1px solid var(--border-color);
}

.streak-modal-header h4 {
    color: var(--text-primary);
    margin: 0;
    font-size: 1.25rem;
}

.streak-modal-body {
    padding: 2rem;
}

.streak-stats {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.streak-stat-item {
    text-align: center;
    padding: 1.5rem;
    background: var(--bg-tertiary);
    border-radius: 12px;
    border: 1px solid var(--border-color);
}

.streak-stat-value {
    font-size: 2rem;
    font-weight: 700;
    color: var(--accent-lavender);
    margin-bottom: 0.5rem;
}

.streak-stat-label {
    font-size: 0.875rem;
    color: var(--text-secondary);
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.streak-periods {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1rem;
    margin-bottom: 2rem;
}

.streak-period {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem;
    background: var(--bg-tertiary);
    border-radius: 8px;
    border: 1px solid var(--border-color);
}

.period-label {
    color: var(--text-secondary);
    font-size: 0.875rem;
}

.period-value {
    color: var(--text-primary);
    font-weight: 600;
}

.recent-activity h5 {
    color: var(--text-primary);
    margin-bottom: 1rem;
    font-size: 1rem;
}

.activity-grid {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    gap: 0.5rem;
}

.activity-day {
    text-align: center;
    padding: 0.75rem 0.5rem;
    border-radius: 8px;
    border: 1px solid var(--border-color);
    background: var(--bg-tertiary);
}

.activity-day.present {
    background: rgba(16, 185, 129, 0.2);
    border-color: #10b981;
    color: #10b981;
}

.activity-day.missed {
    background: rgba(239, 68, 68, 0.2);
    border-color: #ef4444;
    color: #ef4444;
}

.activity-day.no_record {
    opacity: 0.5;
}

.activity-day-name {
    font-size: 0.75rem;
    margin-bottom: 0.25rem;
    color: var(--text-muted);
}

.activity-day-status {
    font-size: 0.875rem;
    font-weight: 600;
}
</style>

<script>
function showStreakDetails() {
    fetch('/student/streak-details')
        .then(response => response.json())
        .then(data => {
            // Update modal content
            document.getElementById('currentStreakValue').textContent = data.current_streak;
            document.getElementById('longestStreakValue').textContent = data.longest_streak;
            document.getElementById('totalDaysValue').textContent = data.total_days;
            document.getElementById('thisWeekValue').textContent = data.this_week + ' days';
            document.getElementById('thisMonthValue').textContent = data.this_month + ' days';
            
            // Update activity grid
            const activityGrid = document.getElementById('activityGrid');
            activityGrid.innerHTML = '';
            
            data.recent_activity.forEach(day => {
                const dayElement = document.createElement('div');
                dayElement.className = `activity-day ${day.status}`;
                dayElement.innerHTML = `
                    <div class="activity-day-name">${day.day_name}</div>
                    <div class="activity-day-status">${day.present ? '✓' : day.status === 'missed' ? '✗' : '-'}</div>
                `;
                activityGrid.appendChild(dayElement);
            });
            
            // Show modal
            document.getElementById('streakModal').style.display = 'block';
        })
        .catch(error => {
            console.error('Error fetching streak details:', error);
            alert('Unable to load streak details. Please try again.');
        });
}

function closeStreakModal() {
    document.getElementById('streakModal').style.display = 'none';
}

// Close modal when clicking outside
document.addEventListener('click', function(e) {
    const modal = document.getElementById('streakModal');
    if (modal && modal.style.display === 'block' && !modal.contains(e.target)) {
        closeStreakModal();
    }
});
</script>
@endsection
