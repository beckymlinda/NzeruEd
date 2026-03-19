@extends('layouts.app')

@section('title', 'Payment Reminders')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-header">
                <h1 class="page-title">Payment Reminders</h1>
                <div class="page-actions">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#bulkReminderModal">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/>
                            <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
                        </svg>
                        Send Bulk Reminders
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/>
                        <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
                    </svg>
                </div>
                <div class="stat-content">
                    <div class="stat-number">{{ $studentsWithUnpaid->count() }}</div>
                    <div class="stat-label">Students with Unpaid</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="1" y="4" width="22" height="16" rx="2" ry="2"/>
                        <line x1="1" y1="10" x2="23" y2="10"/>
                    </svg>
                </div>
                <div class="stat-content">
                    <div class="stat-number">MWK {{ number_format($studentsWithUnpaid->sum(function($enrollment) {
                        $totalPaid = $enrollment->payments()->where('status', 'approved')->sum('amount_paid');
                        $expectedAmount = $enrollment->payments()->whereNotNull('expected_amount')->sum('expected_amount') ?: 120000;
                        return max(0, $expectedAmount - $totalPaid);
                    }), 0) }}</div>
                    <div class="stat-label">Total Unpaid Amount</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                        <polyline points="22 4 12 14.01 9 11.01"/>
                    </svg>
                </div>
                <div class="stat-content">
                    <div class="stat-number">{{ $studentsWithUnpaid->where(function($enrollment) {
                        $totalPaid = $enrollment->payments()->where('status', 'approved')->sum('amount_paid');
                        $expectedAmount = $enrollment->payments()->whereNotNull('expected_amount')->sum('expected_amount') ?: 120000;
                        return $totalPaid > 0 && $totalPaid < $expectedAmount;
                    })->count() }}</div>
                    <div class="stat-label">Partial Payments</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/>
                        <line x1="15" y1="9" x2="9" y2="15"/>
                        <line x1="9" y1="9" x2="15" y2="15"/>
                    </svg>
                </div>
                <div class="stat-content">
                    <div class="stat-number">{{ $studentsWithUnpaid->where(function($enrollment) {
                        return $enrollment->payments()->where('status', 'approved')->sum('amount_paid') == 0;
                    })->count() }}</div>
                    <div class="stat-label">No Payments</div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="reminders-table-card">
                <div class="card-header">
                    <h3>Students with Unpaid Balances</h3>
                    <div class="table-actions">
                        <div class="filter-buttons">
                            <button class="btn-filter active" onclick="filterStudents('all')">All</button>
                            <button class="btn-filter" onclick="filterStudents('partial')">Partial</button>
                            <button class="btn-filter" onclick="filterStudents('none')">No Payment</button>
                        </div>
                    </div>
                </div>

                <div class="table-container">
                    @if($studentsWithUnpaid->count() > 0)
                        <table class="reminders-table">
                            <thead>
                                <tr>
                                    <th>
                                        <input type="checkbox" id="selectAll" onchange="toggleSelectAll()">
                                    </th>
                                    <th>Student</th>
                                    <th>Program</th>
                                    <th>Total Paid</th>
                                    <th>Expected</th>
                                    <th>Balance</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($studentsWithUnpaid as $enrollment)
                                    @php
                                        $totalPaid = $enrollment->payments()->where('status', 'approved')->sum('amount_paid');
                                        $expectedAmount = $enrollment->payments()->whereNotNull('expected_amount')->sum('expected_amount') ?: 120000;
                                        $balance = $expectedAmount - $totalPaid;
                                        $paymentStatus = $totalPaid >= $expectedAmount ? 'paid' : ($totalPaid > 0 ? 'partial' : 'none');
                                    @endphp
                                    <tr class="student-row" data-status="{{ $paymentStatus }}">
                                        <td>
                                            <input type="checkbox" class="student-checkbox" value="{{ $enrollment->id }}">
                                        </td>
                                        <td>
                                            <div class="student-info">
                                                <div class="student-name">{{ $enrollment->user->name }}</div>
                                                <div class="student-email">{{ $enrollment->user->email }}</div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="program-name">{{ $enrollment->program->title }}</span>
                                        </td>
                                        <td>
                                            <span class="amount-cell paid">MWK {{ number_format($totalPaid, 0) }}</span>
                                        </td>
                                        <td>
                                            <span class="amount-cell expected">MWK {{ number_format($expectedAmount, 0) }}</span>
                                        </td>
                                        <td>
                                            <span class="amount-cell balance">MWK {{ number_format($balance, 0) }}</span>
                                        </td>
                                        <td>
                                            <span class="status-badge {{ $paymentStatus }}">
                                                @if($paymentStatus == 'partial')
                                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                        <circle cx="12" cy="12" r="10"/>
                                                        <polyline points="12 6 12 12 16 14"/>
                                                    </svg>
                                                    Partial
                                                @else
                                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                        <circle cx="12" cy="12" r="10"/>
                                                        <line x1="15" y1="9" x2="9" y2="15"/>
                                                        <line x1="9" y1="9" x2="15" y2="15"/>
                                                    </svg>
                                                    No Payment
                                                @endif
                                            </span>
                                        </td>
                                        <td>
                                            <div class="action-buttons">
                                                <button class="btn-action btn-reminder" onclick="sendSingleReminder({{ $enrollment->id }}, '{{ $enrollment->user->name }}', {{ $balance }})">
                                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/>
                                                        <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
                                                    </svg>
                                                    Send Reminder
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="empty-state">
                            <div class="empty-icon">
                                <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                                    <polyline points="22 4 12 14.01 9 11.01"/>
                                </svg>
                            </div>
                            <h4>All Students Paid Up!</h4>
                            <p>Great news! All students have paid their fees. No payment reminders needed at this time.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bulk Reminder Modal -->
<div class="modal fade" id="bulkReminderModal" tabindex="-1" aria-labelledby="bulkReminderModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bulkReminderModalLabel">Send Bulk Payment Reminders</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('admin.payment-reminders.bulk') }}">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-info">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"/>
                            <line x1="12" y1="16" x2="12" y2="12"/>
                            <line x1="12" y1="8" x2="12.01" y2="8"/>
                        </svg>
                        Select students from the table below or leave empty to send to all students with unpaid balances.
                    </div>
                    
                    <div class="form-group mb-3">
                        <label for="amount" class="form-label">Reminder Amount (MWK)</label>
                        <input type="number" class="form-control" id="amount" name="amount" value="120000" min="1" required>
                        <div class="form-text">Default: MWK 120,000 (monthly rate)</div>
                    </div>
                    
                    <div class="form-group mb-3">
                        <label for="due_date" class="form-label">Due Date</label>
                        <input type="date" class="form-control" id="due_date" name="due_date" required>
                    </div>
                    
                    <div class="form-group mb-3">
                        <label for="message" class="form-label">Custom Message (Optional)</label>
                        <textarea class="form-control" id="message" name="message" rows="3" placeholder="Leave empty to use default message"></textarea>
                    </div>
                    
                    <div class="form-group mb-3">
                        <label class="form-label">Selected Students</label>
                        <div class="selected-students">
                            <span id="selectedCount">0</span> students selected
                            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="clearSelection()">Clear Selection</button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/>
                            <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
                        </svg>
                        Send Reminders
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

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
    --error-color: #ef4444;
    --border-color: #3a3a3a;
}

.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
}

.page-title {
    font-size: 2rem;
    font-weight: 700;
    color: var(--text-primary);
    margin: 0;
}

.page-actions {
    display: flex;
    gap: 1rem;
}

.stat-card {
    background: var(--bg-secondary);
    border-radius: 16px;
    padding: 1.5rem;
    border: 1px solid var(--border-color);
    display: flex;
    align-items: center;
    gap: 1rem;
}

.stat-icon {
    width: 48px;
    height: 48px;
    background: var(--accent-lavender);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
}

.stat-content {
    flex: 1;
}

.stat-number {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--text-primary);
    line-height: 1.2;
}

.stat-label {
    color: var(--text-secondary);
    font-size: 0.875rem;
}

.reminders-table-card {
    background: var(--bg-secondary);
    border-radius: 20px;
    border: 1px solid var(--border-color);
    overflow: hidden;
}

.card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1.5rem 2rem;
    border-bottom: 1px solid var(--border-color);
}

.card-header h3 {
    color: var(--text-primary);
    margin: 0;
    font-size: 1.25rem;
    font-weight: 600;
}

.filter-buttons {
    display: flex;
    gap: 0.5rem;
}

.btn-filter {
    background: var(--bg-tertiary);
    border: 1px solid var(--border-color);
    color: var(--text-secondary);
    padding: 0.5rem 1rem;
    border-radius: 8px;
    font-size: 0.875rem;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-filter.active,
.btn-filter:hover {
    background: var(--accent-lavender);
    color: white;
    border-color: var(--accent-lavender);
}

.table-container {
    overflow-x: auto;
}

.reminders-table {
    width: 100%;
    border-collapse: collapse;
}

.reminders-table th {
    background: var(--bg-tertiary);
    color: var(--text-secondary);
    font-weight: 600;
    text-align: left;
    padding: 1rem;
    font-size: 0.875rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.reminders-table td {
    padding: 1rem;
    border-bottom: 1px solid var(--border-color);
    vertical-align: middle;
}

.reminders-table tr:hover {
    background: var(--bg-tertiary);
}

.student-info {
    display: flex;
    flex-direction: column;
}

.student-name {
    font-weight: 600;
    color: var(--text-primary);
}

.student-email {
    font-size: 0.75rem;
    color: var(--text-muted);
}

.program-name {
    color: var(--text-secondary);
    font-size: 0.875rem;
}

.amount-cell {
    font-weight: 600;
    font-size: 0.875rem;
}

.amount-cell.paid {
    color: var(--success-color);
}

.amount-cell.expected {
    color: var(--text-secondary);
}

.amount-cell.balance {
    color: var(--warning-color);
}

.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.25rem 0.75rem;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 500;
}

.status-badge.partial {
    background: rgba(245, 158, 11, 0.2);
    color: var(--warning-color);
}

.status-badge.none {
    background: rgba(239, 68, 68, 0.2);
    color: var(--error-color);
}

.action-buttons {
    display: flex;
    gap: 0.5rem;
}

.btn-action {
    background: none;
    border: 1px solid var(--border-color);
    color: var(--text-secondary);
    padding: 0.5rem;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.3s ease;
    font-size: 0.75rem;
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
}

.btn-action:hover {
    background: var(--bg-tertiary);
    color: var(--text-primary);
}

.btn-action.btn-reminder:hover {
    border-color: var(--accent-lavender);
    color: var(--accent-lavender);
}

.empty-state {
    text-align: center;
    padding: 4rem 2rem;
    color: var(--text-secondary);
}

.empty-icon svg {
    width: 64px;
    height: 64px;
    margin-bottom: 1.5rem;
    opacity: 0.5;
    color: var(--success-color);
}

.empty-state h4 {
    color: var(--text-primary);
    margin-bottom: 0.5rem;
}

.empty-state p {
    margin-bottom: 0;
}

.selected-students {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 0.75rem;
    background: var(--bg-tertiary);
    border-radius: 8px;
    border: 1px solid var(--border-color);
}

#selectedCount {
    font-weight: 600;
    color: var(--accent-lavender);
}

/* Modal Styles */
.modal-content {
    background: var(--bg-secondary);
    border: 1px solid var(--border-color);
}

.modal-header {
    border-bottom-color: var(--border-color);
}

.modal-title {
    color: var(--text-primary);
}

.btn-close {
    filter: invert(1);
}

.form-label {
    color: var(--text-primary);
    font-weight: 500;
}

.form-control {
    background: var(--bg-tertiary);
    border: 1px solid var(--border-color);
    color: var(--text-primary);
}

.form-control:focus {
    background: var(--bg-tertiary);
    border-color: var(--accent-lavender);
    color: var(--text-primary);
    box-shadow: 0 0 0 0.2rem rgba(155, 89, 182, 0.25);
}

.form-text {
    color: var(--text-muted);
}

.alert-info {
    background: rgba(59, 130, 246, 0.1);
    border: 1px solid rgba(59, 130, 246, 0.3);
    color: #60a5fa;
}

@media (max-width: 768px) {
    .page-header {
        flex-direction: column;
        gap: 1rem;
        align-items: flex-start;
    }
    
    .stat-card {
        margin-bottom: 1rem;
    }
    
    .filter-buttons {
        flex-wrap: wrap;
    }
}
</style>

<script>
function toggleSelectAll() {
    const selectAll = document.getElementById('selectAll');
    const checkboxes = document.querySelectorAll('.student-checkbox');
    
    checkboxes.forEach(checkbox => {
        checkbox.checked = selectAll.checked;
    });
    
    updateSelectedCount();
}

function updateSelectedCount() {
    const checkboxes = document.querySelectorAll('.student-checkbox:checked');
    document.getElementById('selectedCount').textContent = checkboxes.length;
}

function clearSelection() {
    document.querySelectorAll('.student-checkbox').forEach(checkbox => {
        checkbox.checked = false;
    });
    document.getElementById('selectAll').checked = false;
    updateSelectedCount();
}

function filterStudents(status) {
    const rows = document.querySelectorAll('.student-row');
    const buttons = document.querySelectorAll('.btn-filter');
    
    // Update active button
    buttons.forEach(btn => btn.classList.remove('active'));
    event.target.classList.add('active');
    
    // Filter rows
    rows.forEach(row => {
        if (status === 'all') {
            row.style.display = '';
        } else {
            row.style.display = row.dataset.status === status ? '' : 'none';
        }
    });
}

function sendSingleReminder(enrollmentId, studentName, balance) {
    const amount = prompt(`Enter reminder amount for ${studentName} (Current balance: MWK ${balance.toLocaleString()}):`, balance);
    if (amount) {
        const dueDate = prompt('Enter due date (YYYY-MM-DD):', new Date(Date.now() + 7 * 24 * 60 * 60 * 1000).toISOString().split('T')[0]);
        if (dueDate) {
            // Create form and submit
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route('admin.payment-reminders.create') }}';
            
            // Add CSRF token
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            form.appendChild(csrfToken);
            
            // Add user_id (convert enrollment_id to user_id)
            const userId = document.createElement('input');
            userId.type = 'hidden';
            userId.name = 'user_id';
            // Find the user_id from the row
            const row = document.querySelector(`input[value="${enrollmentId}"]`).closest('tr');
            const studentName = row.querySelector('.student-name').textContent;
            // In real implementation, you'd need to pass the actual user_id
            userId.value = enrollmentId; // This should be user_id in real implementation
            form.appendChild(userId);
            
            // Add amount
            const amountInput = document.createElement('input');
            amountInput.type = 'hidden';
            amountInput.name = 'amount';
            amountInput.value = amount;
            form.appendChild(amountInput);
            
            // Add due_date
            const dueDateInput = document.createElement('input');
            dueDateInput.type = 'hidden';
            dueDateInput.name = 'due_date';
            dueDateInput.value = dueDate;
            form.appendChild(dueDateInput);
            
            document.body.appendChild(form);
            form.submit();
        }
    }
}

// Update selected count when checkboxes change
document.addEventListener('DOMContentLoaded', function() {
    const checkboxes = document.querySelectorAll('.student-checkbox');
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updateSelectedCount);
    });
    
    // Set minimum due date to tomorrow
    const dueDateInput = document.getElementById('due_date');
    if (dueDateInput) {
        const tomorrow = new Date();
        tomorrow.setDate(tomorrow.getDate() + 1);
        dueDateInput.min = tomorrow.toISOString().split('T')[0];
        dueDateInput.value = tomorrow.toISOString().split('T')[0];
    }
});
</script>
@endsection
