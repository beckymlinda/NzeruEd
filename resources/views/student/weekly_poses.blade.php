@extends('layouts.app')

@section('title', 'Weekly Poses')

@section('content')
<div class="weekly-poses-wrapper">
    <div class="container-fluid py-4">
        <!-- Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="page-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h1 class="page-title">
                                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="me-3">
                                    <path d="M12 2L2 7v10c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V7l-10-5z"/>
                                </svg>
                                Weekly Poses
                            </h1>
                            <p class="page-subtitle">Master your practice with targeted poses each week</p>
                        </div>
                        <div class="pose-stats">
                            <div class="stat-item">
                                <div class="stat-number">{{ $poses->count() }}</div>
                                <div class="stat-label">Total Poses</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if(isset($message))
            <div class="alert alert-lavender">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="me-2">
                    <circle cx="12" cy="12" r="10"/>
                    <line x1="12" y1="16" x2="12" y2="12"/>
                    <line x1="12" y1="8" x2="12.01" y2="8"/>
                </svg>
                {{ $message }}
            </div>
        @elseif($poses->isEmpty())
            <div class="empty-state-card">
                <div class="empty-icon">
                    <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1">
                        <path d="M12 2L2 7v10c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V7l-10-5z"/>
                    </svg>
                </div>
                <h3>No Weekly Poses Yet</h3>
                <p>Your instructor will add weekly poses soon. Check back later!</p>
            </div>
        @else
            <div class="row g-4">
                @foreach($poses as $pose)
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="pose-card">
                            <!-- Pose Image -->
                            <div class="pose-image-container">
                                @if($pose->media_path)
                                    <img src="{{ asset('storage/'.$pose->media_path) }}" 
                                         class="pose-image" 
                                         alt="{{ $pose->pose_name }}"
                                         loading="lazy">
                                @else
                                    <div class="pose-no-image">
                                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M12 2L2 7v10c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V7l-10-5z"/>
                                        </svg>
                                        <span>No Image</span>
                                    </div>
                                @endif>
                                
                                <!-- Week Badge -->
                                <div class="week-badge">
                                    Week {{ $pose->weeklyTarget->week_number ?? '-' }}
                                </div>
                            </div>

                            <!-- Card Body -->
                            <div class="pose-card-body">
                                <h3 class="pose-name">{{ $pose->pose_name }}</h3>
                                
                                <div class="pose-meta">
                                    <div class="meta-item">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <circle cx="12" cy="12" r="10"/>
                                            <polyline points="12 6 12 12 16 14"/>
                                        </svg>
                                        {{ $pose->hold_time_seconds ?? '-' }}s hold
                                    </div>
                                    <div class="meta-item">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/>
                                        </svg>
                                        {{ $pose->weeklyTarget->focus_area ?? '-' }}
                                    </div>
                                </div>

                                @if($pose->notes)
                                    <div class="pose-notes">
                                        <div class="notes-header">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                                <polyline points="14,2 14,8 20,8"/>
                                                <line x1="16" y1="13" x2="8" y2="13"/>
                                                <line x1="16" y1="17" x2="8" y2="17"/>
                                                <polyline points="10,9 9,9 8,9"/>
                                            </svg>
                                            Instructor Notes
                                        </div>
                                        <div class="notes-content" id="notes-{{ $pose->id }}">
                                            {!! nl2br(e($pose->notes)) !!}
                                        </div>
                                        @if(strlen($pose->notes) > 150)
                                            <button class="read-more-btn" onclick="toggleNotes({{ $pose->id }})" id="toggle-{{ $pose->id }}">
                                                Read More
                                            </button>
                                        @endif
                                    </div>
                                @endif

                                <div class="pose-actions">
                                    <button class="btn-practice" onclick="markAsPracticed({{ $pose->id }})">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                                            <polyline points="22 4 12 14.01 9 11.01"/>
                                        </svg>
                                        Mark as Practiced
                                    </button>
                                </div>
                            </div>
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
}

.weekly-poses-wrapper {
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

.pose-stats {
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

/* Alert */
.alert-lavender {
    background: var(--bg-secondary);
    border: 1px solid var(--accent-lavender);
    border-radius: 12px;
    padding: 1rem 1.5rem;
    color: var(--text-primary);
    display: flex;
    align-items: center;
    margin-bottom: 1.5rem;
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

/* Pose Cards */
.pose-card {
    background: var(--bg-secondary);
    border: 1px solid var(--border-color);
    border-radius: 16px;
    overflow: hidden;
    transition: all 0.3s ease;
    height: 100%;
    display: flex;
    flex-direction: column;
}

.pose-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 40px rgba(0, 0, 0, 0.4);
    border-color: var(--accent-lavender);
}

.pose-image-container {
    position: relative;
    height: 250px;
    overflow: hidden;
}

.pose-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.pose-card:hover .pose-image {
    transform: scale(1.05);
}

.pose-no-image {
    width: 100%;
    height: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    background: var(--bg-tertiary);
    color: var(--text-muted);
}

.pose-no-image svg {
    margin-bottom: 1rem;
}

.week-badge {
    position: absolute;
    top: 1rem;
    right: 1rem;
    background: var(--accent-lavender);
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    box-shadow: 0 4px 12px rgba(155, 89, 182, 0.3);
}

.pose-card-body {
    padding: 1.5rem;
    flex: 1;
    display: flex;
    flex-direction: column;
}

.pose-name {
    font-size: 1.25rem;
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 1rem;
    text-align: center;
}

.pose-meta {
    display: flex;
    justify-content: space-around;
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid var(--border-color);
}

.meta-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.875rem;
    color: var(--text-secondary);
}

.pose-notes {
    margin-bottom: 1.5rem;
    flex: 1;
}

.notes-header {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--accent-lavender);
    margin-bottom: 0.75rem;
}

.notes-content {
    font-size: 0.875rem;
    color: var(--text-secondary);
    line-height: 1.6;
    max-height: 100px;
    overflow: hidden;
    transition: max-height 0.3s ease;
}

.notes-content.expanded {
    max-height: none;
}

.read-more-btn {
    background: none;
    border: none;
    color: var(--accent-lavender);
    font-size: 0.875rem;
    font-weight: 500;
    cursor: pointer;
    padding: 0.5rem 0;
    transition: color 0.2s ease;
}

.read-more-btn:hover {
    color: var(--accent-lavender-light);
}

.pose-actions {
    margin-top: auto;
}

.btn-practice {
    width: 100%;
    background: linear-gradient(135deg, var(--accent-lavender), var(--accent-lavender-dark));
    border: none;
    color: white;
    padding: 0.75rem 1.5rem;
    border-radius: 12px;
    font-weight: 600;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    transition: all 0.3s ease;
    cursor: pointer;
}

.btn-practice:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(155, 89, 182, 0.4);
}

/* Responsive */
@media (max-width: 768px) {
    .page-header {
        padding: 1.5rem;
    }
    
    .page-title {
        font-size: 1.5rem;
    }
    
    .pose-stats {
        padding: 0.75rem 1rem;
    }
    
    .pose-image-container {
        height: 200px;
    }
    
    .pose-card-body {
        padding: 1rem;
    }
}
</style>

<!-- JavaScript -->
<script>
function toggleNotes(id) {
    const notes = document.getElementById(`notes-${id}`);
    const toggle = document.getElementById(`toggle-${id}`);

    if (notes.classList.contains('expanded')) {
        notes.classList.remove('expanded');
        toggle.textContent = 'Read More';
    } else {
        notes.classList.add('expanded');
        toggle.textContent = 'Read Less';
    }
}

function markAsPracticed(poseId) {
    // Placeholder for marking pose as practiced
    alert('Pose marked as practiced! (This would save to database)');
}
</script>
@endsection
