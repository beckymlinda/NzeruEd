@extends('layouts.app')

@section('title', 'My Assignments')

@section('content')
<div class="assignments-wrapper">
    <div class="container-fluid py-4">
        <!-- Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="page-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h1 class="page-title">
                                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="me-3">
                                    <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/>
                                    <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/>
                                    <path d="M12 3v18"/>
                                </svg>
                                My Assignments
                            </h1>
                            <p class="page-subtitle">Track and manage your yoga assignments</p>
                        </div>
                        <div class="assignments-stats">
                            <div class="stat-item">
                                <div class="stat-number">{{ $assignments->count() }}</div>
                                <div class="stat-label">Total Tasks</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Assignments List -->
        <div class="assignments-list">
            @forelse($assignments as $assignment)
                <div class="assignment-item">
                    <div class="assignment-info">
                        <div class="assignment-title">{{ $assignment->title }}</div>
                        <div class="assignment-meta">
                            <span class="due-date">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                                    <line x1="16" y1="2" x2="16" y2="6"/>
                                    <line x1="8" y1="2" x2="8" y2="6"/>
                                    <line x1="3" y1="10" x2="21" y2="10"/>
                                </svg>
                                Due {{ \Carbon\Carbon::parse($assignment->due_date)->format('M d, Y') }}
                            </span>
                            @php
                                $daysUntilDue = \Carbon\Carbon::parse($assignment->due_date)->diffInDays(\Carbon\Carbon::now(), false);
                                $statusClass = $daysUntilDue < 0 ? 'overdue' : ($daysUntilDue <= 3 ? 'due-soon' : 'on-time');
                                $statusText = $daysUntilDue < 0 ? 'Overdue' : ($daysUntilDue <= 3 ? 'Due Soon' : 'On Time');
                                $submission = $assignment->submissions->firstWhere('user_id', auth()->id());
                                $submissionStatus = $submission ? 'submitted' : 'pending';
                            @endphp
                            <span class="status-badge {{ $statusClass }}">{{ $statusText }}</span>
                            <span class="submission-status {{ $submissionStatus }}">
                                {{ $submission ? 'Submitted' : 'Pending' }}
                            </span>
                        </div>
                    </div>
                    <div class="assignment-actions">
                        <button class="action-btn view-btn" onclick="openAssignmentModal({{ $assignment->id }})">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                            View
                        </button>
                        @if($submission)
                            <button class="action-btn edit-btn" onclick="editSubmission({{ $submission->id }})">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                </svg>
                                Edit
                            </button>
                            <button class="action-btn delete-btn" onclick="deleteSubmission({{ $submission->id }})">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polyline points="3 6 5 6 21 6"/>
                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                                </svg>
                                Delete
                            </button>
                        @endif
                    </div>
                </div>
            @empty
                <div class="empty-state-card">
                    <div class="empty-icon">
                        <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1">
                            <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/>
                            <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/>
                            <path d="M12 3v18"/>
                        </svg>
                    </div>
                    <h3>No Assignments Yet</h3>
                    <p>Your assignments will appear here once they are assigned by your instructor.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

<!-- Assignment Details Modal -->
<div id="assignmentModal" class="assignment-modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2 class="modal-title">Assignment Details</h2>
            <button class="modal-close" onclick="closeAssignmentModal()">×</button>
        </div>
        
        <div class="modal-body" id="modalBody">
            <!-- Content will be loaded dynamically -->
        </div>
    </div>
</div>

<!-- Image Preview Modal -->
<div id="imagePreviewModal" class="assignment-modal">
    <div class="modal-content image-preview-content">
        <div class="modal-header">
            <h2 class="modal-title">Image Preview</h2>
            <button class="modal-close" onclick="closeImagePreview()">×</button>
        </div>
        
        <div class="modal-body">
            <div class="image-preview-container">
                <img id="previewImage" src="" alt="Assignment Image" style="max-width: 100%; height: auto; border-radius: 8px;">
            </div>
            <div class="image-actions">
                <a id="downloadImageLink" href="" download class="action-btn view-btn" target="_blank">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                        <polyline points="7 10 12 15 17 10"/>
                        <line x1="12" y1="15" x2="12" y2="3"/>
                    </svg>
                    Download Image
                </a>
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

.assignments-wrapper {
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

.assignments-stats {
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

/* Assignments List */
.assignments-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.assignment-item {
    background: var(--bg-secondary);
    border: 1px solid var(--border-color);
    border-radius: 12px;
    padding: 1.5rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    transition: all 0.3s ease;
}

.assignment-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3);
    border-color: var(--accent-lavender);
}

.assignment-info {
    flex: 1;
}

.assignment-title {
    font-size: 1.1rem;
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 0.5rem;
}

.assignment-meta {
    display: flex;
    align-items: center;
    gap: 1rem;
    flex-wrap: wrap;
}

.due-date {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.875rem;
    color: var(--text-secondary);
}

.status-badge {
    padding: 0.25rem 0.75rem;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.status-badge.on-time {
    background-color: rgba(16, 185, 129, 0.2);
    color: var(--success-color);
}

.status-badge.due-soon {
    background-color: rgba(245, 158, 11, 0.2);
    color: var(--warning-color);
}

.status-badge.overdue {
    background-color: rgba(239, 68, 68, 0.2);
    color: var(--danger-color);
}

.submission-status {
    padding: 0.25rem 0.75rem;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.submission-status.submitted {
    background-color: rgba(16, 185, 129, 0.2);
    color: var(--success-color);
}

.submission-status.pending {
    background-color: rgba(245, 158, 11, 0.2);
    color: var(--warning-color);
}

.assignment-actions {
    display: flex;
    gap: 0.5rem;
}

.action-btn {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    border-radius: 8px;
    font-size: 0.875rem;
    font-weight: 600;
    text-decoration: none;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
    opacity: 0.3;
}

.action-btn:hover {
    opacity: 1;
    transform: translateY(-2px);
}

.action-btn.view-btn {
    background: var(--bg-primary);
    color: var(--accent-lavender);
    border: 1px solid var(--accent-lavender);
}

.action-btn.view-btn:hover {
    background: var(--accent-lavender);
    color: white;
}

.action-btn.edit-btn {
    background: var(--bg-primary);
    color: var(--warning-color);
    border: 1px solid var(--warning-color);
}

.action-btn.edit-btn:hover {
    background: var(--warning-color);
    color: white;
}

.action-btn.delete-btn {
    background: var(--bg-primary);
    color: var(--danger-color);
    border: 1px solid var(--danger-color);
}

.action-btn.delete-btn:hover {
    background: var(--danger-color);
    color: white;
}

/* Modal Styles */
.assignment-modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.8);
    z-index: 1000;
    overflow-y: auto;
}

.modal-content {
    background: var(--bg-secondary);
    border: 1px solid var(--border-color);
    border-radius: 16px;
    margin: 2rem auto;
    max-width: 800px;
    max-height: 90vh;
    overflow-y: auto;
}

.modal-header {
    padding: 2rem;
    border-bottom: 1px solid var(--border-color);
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.modal-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--text-primary);
    margin: 0;
}

.modal-close {
    background: none;
    border: none;
    color: var(--text-secondary);
    font-size: 2rem;
    cursor: pointer;
    padding: 0;
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    transition: all 0.3s ease;
}

.modal-close:hover {
    background: var(--bg-tertiary);
    color: var(--text-primary);
}

.modal-body {
    padding: 2rem;
}

/* Modal Content Styles */
.assignment-detail-header {
    margin-bottom: 2rem;
}

.assignment-detail-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--text-primary);
    margin-bottom: 1rem;
}

.assignment-detail-meta {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
    margin-bottom: 1rem;
}

.assignment-detail-description {
    color: var(--text-secondary);
    line-height: 1.6;
    margin-bottom: 2rem;
}

.assignment-files {
    margin-bottom: 2rem;
}

.section-title {
    font-size: 1.1rem;
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.file-list {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.file-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem;
    background: var(--bg-tertiary);
    border-radius: 8px;
    color: var(--accent-lavender);
    text-decoration: none;
    transition: all 0.3s ease;
}

.file-item:hover {
    background: var(--border-color);
    color: var(--accent-lavender-light);
}

.preview-btn {
    background: var(--bg-tertiary);
    border: 1px solid var(--accent-lavender);
    color: var(--accent-lavender);
    cursor: pointer;
    text-decoration: none;
}

.preview-btn:hover {
    background: var(--accent-lavender);
    color: white;
}

.image-preview-content {
    max-width: 90vw;
    max-height: 90vh;
}

.image-preview-container {
    text-align: center;
    margin-bottom: 1.5rem;
}

.image-actions {
    text-align: center;
}

.submission-section {
    background: var(--bg-tertiary);
    border-radius: 12px;
    padding: 2rem;
    margin-bottom: 2rem;
}

.submission-status-header {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 1.5rem;
    font-weight: 600;
    color: var(--text-primary);
}

.submitted-status {
    color: var(--success-color);
}

.pending-status {
    color: var(--warning-color);
}

.submission-form {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.form-label {
    font-weight: 600;
    color: var(--text-primary);
    font-size: 0.875rem;
}

.file-upload {
    position: relative;
}

.file-input {
    display: none;
}

.file-label {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.5rem;
    padding: 2rem;
    border: 2px dashed var(--border-color);
    border-radius: 12px;
    cursor: pointer;
    transition: all 0.3s ease;
    color: var(--text-secondary);
}

.file-label:hover {
    border-color: var(--accent-lavender);
    color: var(--accent-lavender);
}

.file-name {
    margin-top: 0.5rem;
    font-size: 0.875rem;
    color: var(--accent-lavender);
    font-weight: 600;
}

.form-control {
    background: var(--bg-primary);
    border: 1px solid var(--border-color);
    color: var(--text-primary);
    border-radius: 8px;
    padding: 0.75rem;
    font-size: 0.875rem;
    transition: all 0.3s ease;
}

.form-control:focus {
    outline: none;
    border-color: var(--accent-lavender);
    box-shadow: 0 0 0 3px rgba(155, 89, 182, 0.1);
}

.submit-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    background: linear-gradient(135deg, var(--accent-lavender), var(--accent-lavender-dark));
    color: white;
    padding: 0.75rem 1.5rem;
    border-radius: 12px;
    font-weight: 600;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
}

.submit-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(155, 89, 182, 0.4);
}

.submission-details {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.submission-file {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.submission-file a {
    color: var(--accent-lavender);
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s ease;
}

.submission-file a:hover {
    color: var(--accent-lavender-light);
}

.submission-notes {
    color: var(--text-secondary);
    line-height: 1.5;
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
    
    .assignment-item {
        flex-direction: column;
        gap: 1rem;
        text-align: center;
    }
    
    .assignment-actions {
        justify-content: center;
    }
    
    .assignment-meta {
        justify-content: center;
    }
    
    .modal-content {
        margin: 1rem;
        max-height: 95vh;
    }
    
    .modal-header,
    .modal-body {
        padding: 1rem;
    }
}
</style>

<!-- JavaScript -->
<script>
// Assignment data
const assignmentsData = @json($assignments->toArray());

function openAssignmentModal(assignmentId) {
    const assignment = assignmentsData.find(a => a.id == assignmentId);
    if (!assignment) return;
    
    const modalBody = document.getElementById('modalBody');
    
    modalBody.innerHTML = `
        <div class="assignment-detail-header">
            <h3 class="assignment-detail-title">${assignment.title}</h3>
            <div class="assignment-detail-meta">
                <span class="due-date">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                        <line x1="16" y1="2" x2="16" y2="6"/>
                        <line x1="8" y1="2" x2="8" y2="6"/>
                        <line x1="3" y1="10" x2="21" y2="10"/>
                    </svg>
                    Due ${new Date(assignment.due_date).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })}
                </span>
            </div>
        </div>
        
        <div class="assignment-detail-description">
            <h4 class="section-title">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                    <polyline points="14,2 14,8 20,8"/>
                    <line x1="16" y1="13" x2="8" y2="13"/>
                    <line x1="16" y1="17" x2="8" y2="17"/>
                </svg>
                Description
            </h4>
            <p>${assignment.description}</p>
        </div>
        
        ${assignment.media_path ? `
        <div class="assignment-files">
            <h4 class="section-title">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                    <polyline points="7 10 12 15 17 10"/>
                    <line x1="12" y1="15" x2="12" y2="3"/>
                </svg>
                Assignment Files
            </h4>
            <div class="file-list">
                <a href="/storage/${assignment.media_path}" class="file-item" target="_blank">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                        <polyline points="14,2 14,8 20,8"/>
                    </svg>
                    Download Assignment File
                </a>
                ${assignment.media_path.match(/\.(jpg|jpeg|png|gif|webp)$/i) ? `
                    <button class="file-item preview-btn" onclick="previewImage('${assignment.media_path}')">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                            <circle cx="12" cy="12" r="3"/>
                        </svg>
                        Preview Image
                    </button>
                ` : ''}
            </div>
        </div>
        ` : ''}
        
        <div class="submission-section">
            ${assignment.submission ? `
                <div class="submission-status-header submitted-status">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                        <polyline points="22 4 12 14.01 9 11.01"/>
                    </svg>
                    <span>Submitted</span>
                </div>
                <div class="submission-details">
                    <div class="submission-file">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                            <polyline points="14,2 14,8 20,8"/>
                        </svg>
                        <a href="/storage/${assignment.submission.file_path}" target="_blank">View Submitted File</a>
                        ${assignment.submission.file_path && assignment.submission.file_path.match(/\.(jpg|jpeg|png|gif|webp)$/i) ? `
                            <button class="file-item preview-btn" onclick="previewImage('${assignment.submission.file_path}')">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                    <circle cx="12" cy="12" r="3"/>
                                </svg>
                                Preview Image
                            </button>
                        ` : ''}
                    </div>
                    ${assignment.submission.notes ? `
                        <div class="submission-notes">
                            <strong>Notes:</strong> ${assignment.submission.notes}
                        </div>
                    ` : ''}
                </div>
            ` : `
                <div class="submission-status-header pending-status">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/>
                        <polyline points="12 6 12 12 16 14"/>
                    </svg>
                    <span>Pending Submission</span>
                </div>
                
                <form action="{{ route('student.assignments.submit', ':assignmentId') }}" method="POST" enctype="multipart/form-data" class="submission-form">
                    @csrf
                    <input type="hidden" name="assignment_id" value="${assignment.id}">
                    <div class="form-group">
                        <label class="form-label">Upload Your Response</label>
                        <div class="file-upload">
                            <input type="file" name="file" id="modal-file-${assignment.id}" class="file-input" required>
                            <label for="modal-file-${assignment.id}" class="file-label">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                                    <polyline points="17 8 12 3 7 8"/>
                                    <line x1="12" y1="3" x2="12" y2="15"/>
                                </svg>
                                <span>Choose file or drag here</span>
                            </label>
                            <div class="file-name" id="modal-file-name-${assignment.id}"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Notes (optional)</label>
                        <textarea name="notes" class="form-control" rows="3" placeholder="Add any notes about your submission..."></textarea>
                    </div>
                    <button type="submit" class="submit-btn">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                            <polyline points="22 4 12 14.01 9 11.01"/>
                        </svg>
                        Submit Assignment
                    </button>
                </form>
            `}
        </div>
    `;
    
    // Show modal
    document.getElementById('assignmentModal').style.display = 'block';
    
    // Setup file upload for this modal
    const fileInput = document.getElementById(`modal-file-${assignment.id}`);
    if (fileInput) {
        fileInput.addEventListener('change', function(e) {
            const fileName = e.target.files[0]?.name || '';
            const fileNameElement = document.getElementById(`modal-file-name-${assignment.id}`);
            if (fileNameElement) {
                fileNameElement.textContent = fileName ? `Selected: ${fileName}` : '';
            }
        });
    }
}

function closeAssignmentModal() {
    document.getElementById('assignmentModal').style.display = 'none';
}

function previewImage(imagePath) {
    const modal = document.getElementById('imagePreviewModal');
    const previewImg = document.getElementById('previewImage');
    const downloadLink = document.getElementById('downloadImageLink');
    
    // Set image source with proper asset path
    const fullImagePath = '/storage/' + imagePath;
    previewImg.src = fullImagePath;
    downloadLink.href = fullImagePath;
    
    // Show modal
    modal.style.display = 'block';
    
    // Handle image load error
    previewImg.onerror = function() {
        previewImg.src = 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjQiIGhlaWdodD0iMjQiIHZpZXdCb3g9IjAgMCAyNCAyNCIgZmlsbD0ibm9uZSIgc3Ryb2tlPSIjYjhiOGI4IiBzdHJva2Utd2lkdGg9IjIiPjxyZWN0IHg9IjMiIHk9IjMiIHdpZHRoPSIxOCIgaGVpZ2h0PSIxOCIgcng9IjIiIHJ5PSIyIi8+PGNpcmNsZSBjeD0iOCIgY3k9IjgiIHI9IjEiLz48cGF0aCBkPSJNMjEgMTV2NGEyIDIgMCAwIDEtMiAySDVhMiAyIDAgMCAxLTItMnYtNCIvPjwvc3ZnPg==';
        previewImg.alt = 'Image not available';
    };
}

function closeImagePreview() {
    document.getElementById('imagePreviewModal').style.display = 'none';
}

function editSubmission(id) {
    if (confirm('Edit submission functionality would open an edit modal here. (ID: ' + id + ')')) {
        // Implement edit submission modal
        console.log('Edit submission:', id);
    }
}

function deleteSubmission(id) {
    if (confirm('Are you sure you want to delete this submission?')) {
        // Implement delete submission
        console.log('Delete submission:', id);
        // In real app, this would make an API call to delete
        alert('Delete submission (ID: ' + id + ') - This would be implemented with actual deletion');
    }
}

// Close modal when clicking outside
window.onclick = function(event) {
    const assignmentModal = document.getElementById('assignmentModal');
    const imageModal = document.getElementById('imagePreviewModal');
    
    if (event.target == assignmentModal) {
        closeAssignmentModal();
    }
    if (event.target == imageModal) {
        closeImagePreview();
    }
}
</script>
@endsection
