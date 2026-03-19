@extends('layouts.app')

@section('title', 'My Attendance')

@section('content')
<div class="attendance-wrapper">
    <div class="container-fluid py-4">
        <!-- Animated Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="page-header">
                    <div class="header-content">
                        <div class="header-left">
                            <div class="header-icon">
                                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                                    <line x1="16" y1="2" x2="16" y2="6"/>
                                    <line x1="8" y1="2" x2="8" y2="6"/>
                                    <line x1="3" y1="10" x2="21" y2="10"/>
                                    <path d="M8 14h.01M12 14h.01M16 14h.01"/>
                                </svg>
                            </div>
                            <div class="header-text">
                                <h1 class="page-title">My Attendance</h1>
                                <p class="page-subtitle">Track your yoga journey and progress</p>
                            </div>
                        </div>
                        @if($enrollment)
                            <div class="header-stats">
                                <div class="stat-card">
                                    <div class="stat-value">{{ $attendanceRate }}%</div>
                                    <div class="stat-label">Attendance Rate</div>
                                </div>
                                <div class="stat-card">
                                    <div class="stat-value">{{ $currentStreak }}</div>
                                    <div class="stat-label">Current Streak</div>
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
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                        <line x1="16" y1="2" x2="16" y2="6"/>
                        <line x1="8" y1="2" x2="8" y2="6"/>
                        <line x1="3" y1="10" x2="21" y2="10"/>
                    </svg>
                </div>
                <h2>No Active Enrollment</h2>
                <p>You need to be enrolled in a program to track your attendance.</p>
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
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="overview-card present-card">
                        <div class="card-icon">
                            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                                <polyline points="22 4 12 14.01 9 11.01"/>
                            </svg>
                        </div>
                        <div class="card-content">
                            <div class="card-number">{{ $presentSessions }}</div>
                            <div class="card-label">Sessions Attended</div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="overview-card missed-card">
                        <div class="card-icon">
                            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10"/>
                                <line x1="15" y1="9" x2="9" y2="15"/>
                                <line x1="9" y1="9" x2="15" y2="15"/>
                            </svg>
                        </div>
                        <div class="card-content">
                            <div class="card-number">{{ $missedSessions }}</div>
                            <div class="card-label">Sessions Missed</div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="overview-card total-card">
                        <div class="card-icon">
                            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                                <circle cx="8.5" cy="7" r="4"/>
                                <path d="M20 8v6M23 11h-6"/>
                            </svg>
                        </div>
                        <div class="card-content">
                            <div class="card-number">{{ $totalSessions }}</div>
                            <div class="card-label">Total Sessions</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Weekly Progress Chart -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="chart-card">
                        <div class="chart-header">
                            <h3>Weekly Attendance Progress</h3>
                            <div class="chart-legend">
                                <div class="legend-item">
                                    <div class="legend-color present"></div>
                                    <span>Present</span>
                                </div>
                                <div class="legend-item">
                                    <div class="legend-color missed"></div>
                                    <span>Missed</span>
                                </div>
                            </div>
                        </div>
                        <div class="chart-container">
                            <div class="weekly-chart">
                                @foreach($weeklyStats as $stat)
                                    @if($stat['total'] > 0)
                                        <div class="week-bar">
                                            <div class="week-info">
                                                <span class="week-label">Week {{ $stat['week'] }}</span>
                                                <span class="week-stats">{{ $stat['present'] }}/3</span>
                                            </div>
                                            <div class="week-progress">
                                                <div class="progress-bar present" style="width: {{ ($stat['present'] / 3) * 100 }}%"></div>
                                                <div class="progress-bar missed" style="width: {{ ($stat['missed'] / 3) * 100 }}%"></div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Attendance -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="attendance-card">
                        <div class="card-header">
                            <h3>Recent Attendance</h3>
                            <div class="view-toggle">
                                <button class="toggle-btn active" onclick="showView('recent')">Recent</button>
                                <button class="toggle-btn" onclick="showView('all')">All Sessions</button>
                            </div>
                        </div>
                        
                        <!-- Recent View -->
                        <div id="recent-view" class="attendance-content">
                            <div class="attendance-list">
                                @foreach($recentAttendance as $attendance)
                                    <div class="attendance-item {{ $attendance->status }}">
                                        <div class="attendance-date">
                                            <div class="date-day">{{ \Carbon\Carbon::parse($attendance->session_date)->format('d') }}</div>
                                            <div class="date-month">{{ \Carbon\Carbon::parse($attendance->session_date)->format('M') }}</div>
                                        </div>
                                        <div class="attendance-details">
                                            <div class="session-info">
                                                <h4>Week {{ $attendance->week_number }} - Session {{ $attendance->session_number }}</h4>
                                                <p>{{ \Carbon\Carbon::parse($attendance->session_date)->format('l, F j, Y') }}</p>
                                            </div>
                                            <div class="status-info">
                                                <div class="status-badge {{ $attendance->status }}">
                                                    @if($attendance->status == 'present')
                                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                                                            <polyline points="22 4 12 14.01 9 11.01"/>
                                                        </svg>
                                                        Present
                                                    @else
                                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                            <circle cx="12" cy="12" r="10"/>
                                                            <line x1="15" y1="9" x2="9" y2="15"/>
                                                            <line x1="9" y1="9" x2="15" y2="15"/>
                                                        </svg>
                                                        Missed
                                                    @endif
                                                </div>
                                                @if($attendance->status == 'missed' && $attendance->reason)
                                                    <div class="absence-reason">
                                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                            <circle cx="12" cy="12" r="10"/>
                                                            <line x1="12" y1="16" x2="12" y2="12"/>
                                                            <line x1="12" y1="8" x2="12.01" y2="8"/>
                                                        </svg>
                                                        <span>{{ $attendance->reason }}</span>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- All Sessions View -->
                        <div id="all-view" class="attendance-content" style="display: none;">
                            <div class="weekly-accordion">
                                @foreach($attendanceRecords as $week => $attendances)
                                    <div class="accordion-item">
                                        <div class="accordion-header" onclick="toggleAccordion('week-{{ $week }}')">
                                            <div class="week-title">
                                                <h4>Week {{ $week }}</h4>
                                                <span class="week-summary">
                                                    {{ $attendances->where('status', 'present')->count() }}/3 Present
                                                </span>
                                            </div>
                                            <div class="accordion-icon">
                                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <polyline points="6 9 12 15 18 9"/>
                                                </svg>
                                            </div>
                                        </div>
                                        <div id="week-{{ $week }}" class="accordion-content">
                                            <div class="week-sessions">
                                                @foreach($attendances as $attendance)
                                                    <div class="session-item {{ $attendance->status }}">
                                                        <div class="session-date">
                                                            {{ \Carbon\Carbon::parse($attendance->session_date)->format('M d') }}
                                                        </div>
                                                        <div class="session-details">
                                                            <span class="session-number">Session {{ $attendance->session_number }}</span>
                                                            <div class="session-status">
                                                                @if($attendance->status == 'present')
                                                                    <span class="status-text present">Present</span>
                                                                @else
                                                                    <span class="status-text missed">Missed</span>
                                                                    @if($attendance->reason)
                                                                        <div class="reason-text">
                                                                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                                                <circle cx="12" cy="12" r="10"/>
                                                                                <line x1="12" y1="16" x2="12" y2="12"/>
                                                                                <line x1="12" y1="8" x2="12.01" y2="8"/>
                                                                            </svg>
                                                                            {{ $attendance->reason }}
                                                                        </div>
                                                                    @endif
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Motivational Section -->
            <div class="row">
                <div class="col-12">
                    <div class="motivation-card">
                        <div class="motivation-content">
                            <div class="motivation-icon">
                                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M12 2L2 7v10c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V7l-10-5z"/>
                                </svg>
                            </div>
                            <div class="motivation-text">
                                <h3>Keep Up the Great Work!</h3>
                                <p>
                                    @if($attendanceRate >= 90)
                                        Excellent attendance! You're showing amazing commitment to your yoga journey.
                                    @elseif($attendanceRate >= 75)
                                        Great job! Your consistency is paying off. Keep it up!
                                    @elseif($attendanceRate >= 60)
                                        Good progress! A little more consistency will help you reach your goals faster.
                                    @else
                                        Every session counts! Let's work on improving your attendance together.
                                    @endif
                                </p>
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

.attendance-wrapper {
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
    font-size: 2rem;
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

.overview-card.present-card::before {
    background: linear-gradient(90deg, var(--success-color), #34d399);
}

.overview-card.missed-card::before {
    background: linear-gradient(90deg, var(--danger-color), #f87171);
}

.overview-card.total-card::before {
    background: linear-gradient(90deg, var(--warning-color), #fbbf24);
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

.present-card .card-icon {
    color: var(--success-color);
}

.missed-card .card-icon {
    color: var(--danger-color);
}

.total-card .card-icon {
    color: var(--warning-color);
}

.card-number {
    font-size: 2.5rem;
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

.legend-color {
    width: 12px;
    height: 12px;
    border-radius: 3px;
}

.legend-color.present {
    background: var(--success-color);
}

.legend-color.missed {
    background: var(--danger-color);
}

.weekly-chart {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.week-bar {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.week-info {
    min-width: 120px;
    display: flex;
    flex-direction: column;
}

.week-label {
    font-weight: 600;
    color: var(--text-primary);
}

.week-stats {
    font-size: 0.875rem;
    color: var(--text-secondary);
}

.week-progress {
    flex: 1;
    height: 24px;
    background: var(--bg-tertiary);
    border-radius: 12px;
    overflow: hidden;
    display: flex;
    position: relative;
}

.progress-bar {
    height: 100%;
    transition: width 0.3s ease;
}

.progress-bar.present {
    background: linear-gradient(90deg, var(--success-color), #34d399);
}

.progress-bar.missed {
    background: linear-gradient(90deg, var(--danger-color), #f87171);
}

/* Attendance Card */
.attendance-card {
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

/* Attendance List */
.attendance-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.attendance-item {
    display: flex;
    align-items: center;
    gap: 1.5rem;
    padding: 1.5rem;
    background: var(--bg-tertiary);
    border-radius: 16px;
    border-left: 4px solid transparent;
    transition: all 0.3s ease;
}

.attendance-item.present {
    border-left-color: var(--success-color);
}

.attendance-item.missed {
    border-left-color: var(--danger-color);
}

.attendance-item:hover {
    transform: translateX(5px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
}

.attendance-date {
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

.attendance-details {
    flex: 1;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.session-info h4 {
    font-size: 1.1rem;
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 0.25rem;
}

.session-info p {
    font-size: 0.875rem;
    color: var(--text-secondary);
    margin-bottom: 0;
}

.status-info {
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

.status-badge.present {
    background: rgba(16, 185, 129, 0.2);
    color: var(--success-color);
}

.status-badge.missed {
    background: rgba(239, 68, 68, 0.2);
    color: var(--danger-color);
}

.absence-reason {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.875rem;
    color: var(--text-secondary);
    background: var(--bg-secondary);
    padding: 0.25rem 0.75rem;
    border-radius: 8px;
}

/* Weekly Accordion */
.weekly-accordion {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.accordion-item {
    background: var(--bg-tertiary);
    border-radius: 16px;
    overflow: hidden;
    border: 1px solid var(--border-color);
}

.accordion-header {
    padding: 1.5rem;
    cursor: pointer;
    display: flex;
    justify-content: space-between;
    align-items: center;
    transition: all 0.3s ease;
}

.accordion-header:hover {
    background: var(--bg-secondary);
}

.week-title h4 {
    font-size: 1.1rem;
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 0.25rem;
}

.week-summary {
    font-size: 0.875rem;
    color: var(--text-secondary);
}

.accordion-icon {
    transition: transform 0.3s ease;
}

.accordion-icon svg {
    stroke: var(--text-secondary);
}

.accordion-content {
    display: none;
    padding: 0 1.5rem 1.5rem;
}

.accordion-content.active {
    display: block;
}

.week-sessions {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.session-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem;
    background: var(--bg-secondary);
    border-radius: 12px;
    border-left: 3px solid transparent;
}

.session-item.present {
    border-left-color: var(--success-color);
}

.session-item.missed {
    border-left-color: var(--danger-color);
}

.session-date {
    font-weight: 600;
    color: var(--text-primary);
}

.session-details {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.session-number {
    font-size: 0.875rem;
    color: var(--text-secondary);
}

.status-text.present {
    color: var(--success-color);
    font-weight: 600;
}

.status-text.missed {
    color: var(--danger-color);
    font-weight: 600;
}

.reason-text {
    display: flex;
    align-items: center;
    gap: 0.25rem;
    font-size: 0.75rem;
    color: var(--text-muted);
    background: var(--bg-tertiary);
    padding: 0.25rem 0.5rem;
    border-radius: 6px;
}

/* Motivation Card */
.motivation-card {
    background: linear-gradient(135deg, var(--accent-lavender) 0%, var(--accent-lavender-dark) 100%);
    border-radius: 20px;
    padding: 2rem;
    border: 1px solid rgba(255, 255, 255, 0.1);
}

.motivation-content {
    display: flex;
    align-items: center;
    gap: 2rem;
}

.motivation-icon {
    background: rgba(255, 255, 255, 0.2);
    border-radius: 16px;
    padding: 1.5rem;
    display: flex;
    align-items: center;
    justify-content: center;
    backdrop-filter: blur(10px);
}

.motivation-icon svg {
    stroke: white;
}

.motivation-text h3 {
    font-size: 1.5rem;
    font-weight: 700;
    color: white;
    margin-bottom: 0.5rem;
}

.motivation-text p {
    color: rgba(255, 255, 255, 0.9);
    margin-bottom: 0;
    line-height: 1.6;
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
    
    .attendance-item {
        flex-direction: column;
        text-align: center;
        gap: 1rem;
    }
    
    .attendance-details {
        flex-direction: column;
        gap: 1rem;
        text-align: center;
    }
    
    .status-info {
        text-align: center;
    }
    
    .motivation-content {
        flex-direction: column;
        text-align: center;
        gap: 1rem;
    }
    
    .weekly-chart {
        overflow-x: auto;
    }
    
    .week-bar {
        min-width: 300px;
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

function toggleAccordion(weekId) {
    const content = document.getElementById(weekId);
    const icon = content.previousElementSibling.querySelector('.accordion-icon svg');
    
    if (content.style.display === 'block') {
        content.style.display = 'none';
        content.classList.remove('active');
        icon.style.transform = 'rotate(0deg)';
    } else {
        content.style.display = 'block';
        content.classList.add('active');
        icon.style.transform = 'rotate(180deg)';
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
    
    // Animate attendance items
    document.querySelectorAll('.attendance-item').forEach((item, index) => {
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
