@extends('layouts.app')

@section('title', 'Week ' . $weeklyProgress->week_number . ' Progress Details')

@section('content')
<div class="weekly-progress-detail-wrapper">
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
                                Week {{ $weeklyProgress->week_number }} Progress
                            </h1>
                            <p class="page-subtitle">Detailed performance analysis and feedback</p>
                        </div>
                        <div class="back-nav">
                            <a href="{{ route('student.weekly-progress') }}" class="btn-back">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M19 12H5M12 19l-7-7 7-7"/>
                                </svg>
                                Back to Overview
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="row g-4">
            <!-- Left Column - Scores & Feedback -->
            <div class="col-lg-8">
                <!-- Performance Scores -->
                <div class="content-card">
                    <div class="card-header-custom">
                        <h5 class="card-title">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M18 20V10"/>
                                <path d="M12 20V4"/>
                                <path d="M6 20v-6"/>
                            </svg>
                            Performance Scores
                        </h5>
                    </div>
                    <div class="card-body-custom">
                        <div class="scores-grid">
                            @php
                                $scores = [
                                    'Flexibility' => $weeklyProgress->flexibility_score ?? 0,
                                    'Strength' => $weeklyProgress->strength_score ?? 0,
                                    'Balance' => $weeklyProgress->balance_score ?? 0,
                                    'Mindset' => $weeklyProgress->mindset_score ?? 0
                                ];
                                $avgScore = array_sum($scores) / 4;
                            @endphp

                            @foreach($scores as $label => $score)
                                <div class="score-detail-item">
                                    <div class="score-header">
                                        <span class="score-label">{{ $label }}</span>
                                        <span class="score-value">{{ $score }}/10</span>
                                    </div>
                                    <div class="score-progress">
                                        <div class="progress-bar-container">
                                            <div class="progress-bar-fill" style="width: {{ $score * 10 }}%;">
                                            </div>
                                        </div>
                                        <span class="score-percentage">{{ $score * 10 }}%</span>
                                    </div>
                                    <div class="score-description">
                                        @if($score >= 8)
                                            <span class="excellent">Excellent performance!</span>
                                        @elseif($score >= 6)
                                            <span class="good">Good progress</span>
                                        @elseif($score >= 4)
                                            <span class="progressing">Keep improving</span>
                                        @else
                                            <span class="needs-work">Needs focus</span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach

                            <!-- Overall Score -->
                            <div class="overall-score-card">
                                <div class="overall-header">
                                    <span class="overall-label">Overall Performance</span>
                                    <span class="overall-value">{{ number_format($avgScore, 1) }}/10</span>
                                </div>
                                <div class="overall-progress">
                                    <div class="progress-bar-container">
                                        <div class="progress-bar-fill overall-fill" style="width: {{ $avgScore * 10 }}%;">
                                        </div>
                                    </div>
                                    <span class="overall-percentage">{{ number_format($avgScore * 10, 0) }}%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Instructor Notes -->
                @if($weeklyProgress->instructor_notes)
                    <div class="content-card">
                        <div class="card-header-custom">
                            <h5 class="card-title">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                    <polyline points="14,2 14,8 20,8"/>
                                    <line x1="16" y1="13" x2="8" y2="13"/>
                                    <line x1="16" y1="17" x2="8" y2="17"/>
                                </svg>
                                Instructor Feedback
                            </h5>
                        </div>
                        <div class="card-body-custom">
                            <div class="instructor-feedback">
                                <div class="feedback-content">
                                    {{ $weeklyProgress->instructor_notes }}
                                </div>
                                <div class="feedback-meta">
                                    <span class="feedback-date">
                                        {{ \Carbon\Carbon::parse($weeklyProgress->created_at)->format('M d, Y') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Overall Assessment -->
                @if($weeklyProgress->overall_feedback)
                    <div class="content-card">
                        <div class="card-header-custom">
                            <h5 class="card-title">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M9 11H3v2h6v-2zm0-4H3v2h6V7zm0 8H3v2h6v-2zm12-8h-6v2h6V7zm0 4h-6v2h6v-2zm0 4h-6v2h6v-2z"/>
                                </svg>
                                Overall Assessment
                            </h5>
                        </div>
                        <div class="card-body-custom">
                            <div class="overall-assessment">
                                <div class="assessment-content">
                                    {{ $weeklyProgress->overall_feedback }}
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Right Column - Media & Info -->
            <div class="col-lg-4">
                <!-- Week Info -->
                <div class="content-card">
                    <div class="card-header-custom">
                        <h5 class="card-title">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10"/>
                                <polyline points="12 6 12 12 16 14"/>
                            </svg>
                            Week Information
                        </h5>
                    </div>
                    <div class="card-body-custom">
                        <div class="week-info-list">
                            <div class="info-item">
                                <span class="info-label">Week Number</span>
                                <span class="info-value">Week {{ $weeklyProgress->week_number }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Date Recorded</span>
                                <span class="info-value">{{ \Carbon\Carbon::parse($weeklyProgress->created_at)->format('M d, Y') }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Program</span>
                                <span class="info-value">{{ $weeklyProgress->enrollment->program->title ?? 'N/A' }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Status</span>
                                @php
                                    $status = $avgScore >= 8 ? 'Excellent' : ($avgScore >= 6 ? 'Good' : ($avgScore >= 4 ? 'Progressing' : 'Needs Work'));
                                    $statusColor = $avgScore >= 8 ? '#10b981' : ($avgScore >= 6 ? '#9b59b6' : ($avgScore >= 4 ? '#f59e0b' : '#ef4444'));
                                @endphp
                                <span class="info-value status-badge" style="background-color: {{ $statusColor }}20; color: {{ $statusColor }};">
                                    {{ $status }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Practice Media -->
                @if($weeklyProgress->progressMedia->count())
                    <div class="content-card">
                        <div class="card-header-custom">
                            <h5 class="card-title">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <rect x="3" y="3" width="18" height="18" rx="2" ry="2"/>
                                    <circle cx="8.5" cy="8.5" r="1.5"/>
                                    <polyline points="21 15 16 10 5 21"/>
                                </svg>
                                Practice Media
                                <span class="media-count">{{ $weeklyProgress->progressMedia->count() }} files</span>
                            </h5>
                        </div>
                        <div class="card-body-custom">
                            <div class="media-gallery">
                                @foreach($weeklyProgress->progressMedia as $media)
                                    <div class="media-item">
                                        @if($media->media_type === 'photo')
                                            <img src="{{ asset('storage/'.$media->file_path) }}" 
                                                 alt="Progress media" 
                                                 class="media-image"
                                                 loading="lazy">
                                            <div class="media-overlay">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                                    <circle cx="12" cy="12" r="3"/>
                                                </svg>
                                                <span>View Photo</span>
                                            </div>
                                        @elseif($media->media_type === 'video')
                                            <video class="media-video" controls>
                                                <source src="{{ asset('storage/'.$media->file_path) }}" type="video/mp4">
                                                Your browser does not support the video tag.
                                            </video>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Quick Actions -->
                <div class="content-card">
                    <div class="card-header-custom">
                        <h5 class="card-title">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/>
                            </svg>
                            Quick Actions
                        </h5>
                    </div>
                    <div class="card-body-custom">
                        <div class="action-buttons">
                            <a href="{{ route('student.weekly-progress') }}" class="action-btn secondary">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                                    <polyline points="9 22 9 12 15 12 15 22"/>
                                </svg>
                                Back to Overview
                            </a>
                            <button class="action-btn primary" onclick="downloadPDF()">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                                    <polyline points="7 10 12 15 17 10"/>
                                    <line x1="12" y1="15" x2="12" y2="3"/>
                                </svg>
                                Download PDF
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Week Progress Navigation -->
                <div class="content-card">
                    <div class="card-header-custom">
                        <h5 class="card-title">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M22 12h-4l-3 9L9 3l-3 9H2"/>
                            </svg>
                            Week Navigation
                        </h5>
                    </div>
                    <div class="card-body-custom">
                        <div class="week-nav-stats">
                            <div class="nav-stat">
                                <span class="nav-label">Current Week</span>
                                <span class="nav-value">Week {{ $weeklyProgress->week_number }}</span>
                            </div>
                            <div class="nav-stat">
                                <span class="nav-label">Weeks Complete</span>
                                <span class="nav-value">{{ $weeklyProgress->week_number - 1 }}/12</span>
                            </div>
                            <div class="nav-stat">
                                <span class="nav-label">Progress</span>
                                <span class="nav-value">{{ round(($weeklyProgress->week_number / 12) * 100) }}%</span>
                            </div>
                        </div>
                        <div class="week-nav-buttons">
                            @if($weeklyProgress->week_number > 1)
                                <button class="nav-btn" onclick="navigateToWeek({{ $weeklyProgress->week_number - 1 }})">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <polyline points="15 18 9 12 15 6"/>
                                        <line x1="21" y1="12" x2="9" y2="12"/>
                                    </svg>
                                    Previous Week
                                </button>
                            @endif
                            @if($weeklyProgress->week_number < 12)
                                <button class="nav-btn" onclick="navigateToWeek({{ $weeklyProgress->week_number + 1 }})">
                                    Next Week
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <polyline points="9 18 15 12 9 6"/>
                                        <line x1="3" y1="12" x2="15" y2="12"/>
                                    </svg>
                                </button>
                            @endif
                        </div>
                    </div>
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
    --success-color: #10b981;
    --warning-color: #f59e0b;
    --danger-color: #ef4444;
}

.weekly-progress-detail-wrapper {
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

.back-nav {
    display: flex;
    align-items: center;
}

.btn-back {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    background: rgba(255, 255, 255, 0.1);
    color: white;
    text-decoration: none;
    padding: 0.75rem 1.5rem;
    border-radius: 12px;
    font-weight: 600;
    transition: all 0.3s ease;
    backdrop-filter: blur(10px);
}

.btn-back:hover {
    background: rgba(255, 255, 255, 0.2);
    color: white;
}

/* Content Cards */
.content-card {
    background: var(--bg-secondary);
    border: 1px solid var(--border-color);
    border-radius: 16px;
    margin-bottom: 1.5rem;
    overflow: hidden;
    transition: all 0.3s ease;
}

.content-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 40px rgba(0, 0, 0, 0.3);
    border-color: var(--accent-lavender);
}

.card-header-custom {
    padding: 1.5rem;
    border-bottom: 1px solid var(--border-color);
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.card-title {
    font-size: 1.1rem;
    font-weight: 600;
    color: var(--text-primary);
    margin: 0;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.media-count {
    background: var(--accent-lavender);
    color: white;
    font-size: 0.75rem;
    padding: 0.25rem 0.75rem;
    border-radius: 12px;
    font-weight: 600;
}

.card-body-custom {
    padding: 1.5rem;
}

/* Scores Grid */
.scores-grid {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.score-detail-item {
    background: var(--bg-tertiary);
    border-radius: 12px;
    padding: 1.5rem;
}

.score-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
}

.score-label {
    font-size: 1rem;
    font-weight: 600;
    color: var(--text-primary);
}

.score-value {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--accent-lavender);
}

.score-progress {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 0.75rem;
}

.progress-bar-container {
    flex: 1;
    background: var(--bg-primary);
    border-radius: 8px;
    height: 12px;
    overflow: hidden;
}

.progress-bar-fill {
    height: 100%;
    background: linear-gradient(90deg, var(--accent-lavender), var(--accent-lavender-dark));
    border-radius: 8px;
    transition: width 0.8s ease;
}

.overall-fill {
    background: linear-gradient(90deg, var(--success-color), #059669);
}

.score-percentage {
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--accent-lavender);
    min-width: 40px;
    text-align: right;
}

.score-description {
    font-size: 0.875rem;
    font-weight: 500;
}

.excellent {
    color: var(--success-color);
}

.good {
    color: var(--accent-lavender);
}

.progressing {
    color: var(--warning-color);
}

.needs-work {
    color: var(--danger-color);
}

/* Overall Score */
.overall-score-card {
    background: linear-gradient(135deg, rgba(16, 185, 129, 0.1), rgba(5, 150, 105, 0.1));
    border: 1px solid var(--success-color);
    border-radius: 12px;
    padding: 1.5rem;
    margin-top: 1rem;
}

.overall-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
}

.overall-label {
    font-size: 1.1rem;
    font-weight: 600;
    color: var(--success-color);
}

.overall-value {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--success-color);
}

.overall-progress {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.overall-percentage {
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--success-color);
    min-width: 40px;
    text-align: right;
}

/* Instructor Feedback */
.instructor-feedback {
    background: var(--bg-tertiary);
    border-radius: 12px;
    padding: 1.5rem;
}

.feedback-content {
    font-size: 1rem;
    color: var(--text-secondary);
    line-height: 1.6;
    margin-bottom: 1rem;
}

.feedback-meta {
    display: flex;
    justify-content: flex-end;
}

.feedback-date {
    font-size: 0.875rem;
    color: var(--text-muted);
}

/* Overall Assessment */
.overall-assessment {
    background: linear-gradient(135deg, rgba(155, 89, 182, 0.1), rgba(142, 68, 173, 0.1));
    border: 1px solid var(--accent-lavender);
    border-radius: 12px;
    padding: 1.5rem;
}

.assessment-content {
    font-size: 1rem;
    color: var(--text-secondary);
    line-height: 1.6;
}

/* Week Info */
.week-info-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.info-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.75rem 0;
    border-bottom: 1px solid var(--border-color);
}

.info-item:last-child {
    border-bottom: none;
}

.info-label {
    font-size: 0.875rem;
    color: var(--text-secondary);
}

.info-value {
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--text-primary);
}

.status-badge {
    padding: 0.25rem 0.75rem;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

/* Media Gallery */
.media-gallery {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.media-item {
    position: relative;
    border-radius: 12px;
    overflow: hidden;
    background: var(--bg-tertiary);
}

.media-image {
    width: 100%;
    height: 200px;
    object-fit: cover;
    display: block;
    transition: transform 0.3s ease;
}

.media-item:hover .media-image {
    transform: scale(1.05);
}

.media-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.7);
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    color: white;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.media-item:hover .media-overlay {
    opacity: 1;
}

.media-overlay svg {
    margin-bottom: 0.5rem;
}

.media-overlay span {
    font-size: 0.875rem;
    font-weight: 600;
}

.media-video {
    width: 100%;
    height: 200px;
    object-fit: cover;
    border-radius: 12px;
}

/* Action Buttons */
.action-buttons {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.action-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    padding: 0.75rem 1rem;
    border-radius: 12px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
    font-size: 0.875rem;
    opacity: 0.3; /* Faint by default */
}

.action-btn:hover {
    opacity: 1; /* Clear on hover */
    transform: translateY(-2px);
}

.action-btn.primary {
    background: linear-gradient(135deg, var(--accent-lavender), var(--accent-lavender-dark));
    color: white;
}

.action-btn.primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(155, 89, 182, 0.4);
}

.action-btn.secondary {
    background: var(--bg-tertiary);
    color: var(--text-primary);
    border: 1px solid var(--border-color);
}

.action-btn.secondary:hover {
    background: var(--border-color);
    color: var(--text-primary);
}

/* Week Navigation Buttons */
.week-nav-stats {
    display: flex;
    flex-direction: column;
    gap: 1rem;
    margin-bottom: 1.5rem;
}

.nav-stat {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.75rem 0;
    border-bottom: 1px solid var(--border-color);
}

.nav-stat:last-child {
    border-bottom: none;
}

.nav-label {
    font-size: 0.875rem;
    color: var(--text-secondary);
}

.nav-value {
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--accent-lavender);
}

.week-nav-buttons {
    display: flex;
    gap: 1rem;
}

.nav-btn {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    padding: 0.75rem 1rem;
    border-radius: 12px;
    font-weight: 600;
    background: var(--bg-tertiary);
    color: var(--text-primary);
    border: 1px solid var(--border-color);
    cursor: pointer;
    transition: all 0.3s ease;
    opacity: 0.3; /* Faint by default */
}

.nav-btn:hover {
    opacity: 1; /* Clear on hover */
    transform: translateY(-2px);
    background: var(--accent-lavender);
    color: white;
    border-color: var(--accent-lavender);
}

/* Responsive */
@media (max-width: 768px) {
    .page-header {
        padding: 1.5rem;
    }
    
    .page-title {
        font-size: 1.5rem;
    }
    
    .page-header .d-flex {
        flex-direction: column;
        gap: 1rem;
        text-align: center;
    }
    
    .score-header {
        flex-direction: column;
        gap: 0.5rem;
        text-align: center;
    }
    
    .score-progress {
        flex-direction: column;
        gap: 0.5rem;
    }
    
    .info-item {
        flex-direction: column;
        gap: 0.25rem;
        text-align: center;
    }
}
</style>

<!-- JavaScript -->
<script>
function downloadPDF() {
    // Direct download without preview
    const downloadUrl = '{{ route("student.weekly-progress.download-pdf", $weeklyProgress->id) }}';
    
    // Create a temporary link and trigger download
    const link = document.createElement('a');
    link.href = downloadUrl;
    link.style.display = 'none';
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
    
    // Show loading indicator
    const btn = event.target;
    const originalText = btn.innerHTML;
    btn.innerHTML = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg> Downloading...';
    btn.disabled = true;
    
    // Re-enable after 3 seconds
    setTimeout(() => {
        btn.innerHTML = originalText;
        btn.disabled = false;
    }, 3000);
}

function navigateToWeek(weekNumber) {
    // Simple navigation for now
    const currentUrl = window.location.href;
    const baseUrl = currentUrl.substring(0, currentUrl.lastIndexOf('/'));
    
    // For demonstration, show an alert
    alert('Week navigation would be implemented here. Week ' + weekNumber + ' would be loaded.');
    
    // In a real implementation, you would:
    // window.location.href = baseUrl + '/' + weekNumber;
}
</script>
@endsection
