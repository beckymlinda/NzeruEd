@extends('layouts.app')

@section('title', 'My Weekly Progress')

@section('content')
<div class="weekly-progress-wrapper">
    <div class="container-fluid py-4">
        <!-- Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="page-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h1 class="page-title">
                                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="me-3">
                                    <path d="M22 12h-4l-3 9L9 3l-3 9H2"/>
                                </svg>
                                Your Weekly Progress
                            </h1>
                            <p class="page-subtitle">Track your yoga journey week by week</p>
                        </div>
                        <div class="progress-stats">
                            <div class="stat-item">
                                <div class="stat-number">{{ $weeklyProgresses->count() }}</div>
                                <div class="stat-label">Weeks Completed</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if($weeklyProgresses->isEmpty())
            <div class="empty-state-card">
                <div class="empty-icon">
                    <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1">
                        <path d="M22 12h-4l-3 9L9 3l-3 9H2"/>
                    </svg>
                </div>
                <h3>No Progress Recorded Yet</h3>
                <p>Your progress tracking will appear here once your instructor starts recording your weekly performance.</p>
            </div>
        @else
            <div class="progress-grid">
                @foreach($weeklyProgresses as $progress)
                    <div class="progress-summary-card">
                        <!-- Week Header -->
                        <div class="week-header">
                            <div class="week-info">
                                <div class="week-number">Week {{ $progress->week_number }}</div>
                                <div class="week-date">{{ \Carbon\Carbon::parse($progress->created_at)->format('M d, Y') }}</div>
                            </div>
                            <div class="week-status">
                                @php
                                    $avgScore = (($progress->flexibility_score ?? 0) + ($progress->strength_score ?? 0) + ($progress->balance_score ?? 0) + ($progress->mindset_score ?? 0)) / 4;
                                    $status = $avgScore >= 8 ? 'Excellent' : ($avgScore >= 6 ? 'Good' : ($avgScore >= 4 ? 'Progressing' : 'Needs Work'));
                                    $statusColor = $avgScore >= 8 ? '#10b981' : ($avgScore >= 6 ? '#9b59b6' : ($avgScore >= 4 ? '#f59e0b' : '#ef4444'));
                                @endphp
                                <span class="status-badge" style="background-color: {{ $statusColor }}20; color: {{ $statusColor }};">
                                    {{ $status }}
                                </span>
                            </div>
                        </div>

                        <!-- Quick Stats -->
                        <div class="quick-stats">
                            <div class="stat-row">
                                <div class="stat-item">
                                    <span class="stat-label">Overall Score</span>
                                    <span class="stat-value">{{ number_format($avgScore, 1) }}/10</span>
                                </div>
                                <div class="stat-item">
                                    <span class="stat-label">Media Files</span>
                                    <span class="stat-value">{{ $progress->progressMedia->count() }}</span>
                                </div>
                            </div>
                            
                            <!-- Mini Progress Bars -->
                            <div class="mini-progress">
                                @php
                                    $scores = [
                                        'Flexibility' => $progress->flexibility_score ?? 0,
                                        'Strength' => $progress->strength_score ?? 0,
                                        'Balance' => $progress->balance_score ?? 0,
                                        'Mindset' => $progress->mindset_score ?? 0
                                    ];
                                @endphp

                                @foreach($scores as $label => $score)
                                    <div class="mini-progress-item">
                                        <span class="mini-label">{{ substr($label, 0, 3) }}</span>
                                        <div class="mini-bar">
                                            <div class="mini-fill" style="width: {{ $score * 10 }}%;"></div>
                                        </div>
                                        <span class="mini-score">{{ $score }}/10</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Instructor Notes Preview -->
                        @if($progress->instructor_notes)
                            <div class="notes-preview">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                    <polyline points="14,2 14,8 20,8"/>
                                    <line x1="16" y1="13" x2="8" y2="13"/>
                                    <line x1="16" y1="17" x2="8" y2="17"/>
                                </svg>
                                <span>{{ Str::limit($progress->instructor_notes, 60) }}</span>
                            </div>
                        @endif

                        <!-- View Details Button -->
                        <div class="card-actions">
                            <a href="{{ route('student.weekly-progress.show', $progress->id) }}" class="btn-view-details">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                    <circle cx="12" cy="12" r="3"/>
                                </svg>
                                View Full Details
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
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
    --success-color: #10b981;
    --warning-color: #f59e0b;
    --danger-color: #ef4444;
}

.weekly-progress-wrapper {
    background: var(--bg-primary);
    min-height: 100vh;
    color: var(--text-primary);
}

/* Page Header */
.page-header {
    background: linear-gradient(135deg, var(--accent-lavender) 0%, var(--accent-lavender-dark) 100%);
    border-radius: 16px;
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: 0 8px 32px rgba(155, 89, 182, 0.2);
}

.page-title {
    font-size: 2rem;
    font-weight: 700;
    color: var(--text-primary);
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
}

.page-subtitle {
    font-size: 1.1rem;
    color: rgba(255, 255, 255, 0.9);
    margin-bottom: 0;
}

.progress-stats {
    display: flex;
    align-items: center;
    gap: 1rem;
    background: rgba(255, 255, 255, 0.1);
    padding: 1rem 1.5rem;
    border-radius: 12px;
    backdrop-filter: blur(10px);
}

.stat-number {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--text-primary);
}

.stat-label {
    font-size: 0.875rem;
    color: rgba(255, 255, 255, 0.8);
}

/* Empty State */
.empty-state-card {
    background: var(--bg-secondary);
    border: 1px solid var(--border-color);
    border-radius: 16px;
    padding: 3rem;
    text-align: center;
    margin-bottom: 2rem;
}

.empty-icon {
    margin-bottom: 1.5rem;
    opacity: 0.5;
}

.empty-icon svg {
    stroke: var(--accent-lavender);
}

.empty-state-card h3 {
    color: var(--text-primary);
    margin-bottom: 1rem;
}

.empty-state-card p {
    color: var(--text-secondary);
    margin-bottom: 0;
}

/* Progress Grid */
.progress-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(400px, 1fr));
    gap: 1.5rem;
}

.progress-summary-card {
    background: var(--bg-secondary);
    border: 1px solid var(--border-color);
    border-radius: 16px;
    overflow: hidden;
    transition: all 0.3s ease;
    display: flex;
    flex-direction: column;
}

.progress-summary-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 40px rgba(0, 0, 0, 0.3);
    border-color: var(--accent-lavender);
}

/* Week Header */
.week-header {
    background: var(--bg-tertiary);
    padding: 1.5rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 1px solid var(--border-color);
}

.week-info {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.week-number {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--accent-lavender);
}

.week-date {
    font-size: 0.875rem;
    color: var(--text-secondary);
}

.status-badge {
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

/* Quick Stats */
.quick-stats {
    padding: 1.5rem;
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.stat-row {
    display: flex;
    justify-content: space-between;
    gap: 1rem;
}

.stat-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.25rem;
}

.stat-label {
    font-size: 0.75rem;
    color: var(--text-muted);
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.stat-value {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--text-primary);
}

/* Mini Progress */
.mini-progress {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.mini-progress-item {
    display: grid;
    grid-template-columns: 60px 1fr 40px;
    align-items: center;
    gap: 0.75rem;
}

.mini-label {
    font-size: 0.75rem;
    font-weight: 600;
    color: var(--text-secondary);
    text-transform: uppercase;
}

.mini-bar {
    background: var(--bg-tertiary);
    border-radius: 4px;
    height: 8px;
    overflow: hidden;
}

.mini-fill {
    height: 100%;
    background: linear-gradient(90deg, var(--accent-lavender), var(--accent-lavender-dark));
    border-radius: 4px;
    transition: width 0.8s ease;
}

.mini-score {
    font-size: 0.75rem;
    font-weight: 600;
    color: var(--accent-lavender);
    text-align: right;
}

/* Notes Preview */
.notes-preview {
    padding: 0 1.5rem 1.5rem;
    display: flex;
    align-items: flex-start;
    gap: 0.5rem;
    font-size: 0.875rem;
    color: var(--text-secondary);
    line-height: 1.4;
}

.notes-preview svg {
    flex-shrink: 0;
    margin-top: 0.125rem;
    color: var(--accent-lavender);
}

/* Card Actions */
.card-actions {
    padding: 1.5rem;
    padding-top: 0;
    margin-top: auto;
}

.btn-view-details {
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    background: linear-gradient(135deg, var(--accent-lavender), var(--accent-lavender-dark));
    color: white;
    text-decoration: none;
    padding: 0.75rem 1.5rem;
    border-radius: 12px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-view-details:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(155, 89, 182, 0.4);
    color: white;
}

/* Responsive */
@media (max-width: 768px) {
    .page-header {
        padding: 1.5rem;
    }
    
    .page-title {
        font-size: 1.5rem;
    }
    
    .progress-grid {
        grid-template-columns: 1fr;
    }
    
    .week-header {
        flex-direction: column;
        gap: 1rem;
        text-align: center;
    }
    
    .stat-row {
        flex-direction: column;
        gap: 1rem;
    }
    
    .mini-progress-item {
        grid-template-columns: 50px 1fr 40px;
    }
}
</style>
@endsection
