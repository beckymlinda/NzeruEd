@extends('layouts.app')

@section('title', 'Payments List')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-header">
                <h1 class="page-title">Payments List</h1>
                <div class="page-actions">
                    <a href="{{ route('admin.payments.create') }}" class="btn btn-primary">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="12" y1="5" x2="12" y2="19"/>
                            <line x1="5" y1="12" x2="19" y2="12"/>
                        </svg>
                        Make Payment
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="payments-table-card">
                <div class="card-header">
                    <h3>All Payments</h3>
                    <div class="table-actions">
                        <div class="search-box">
                            <input type="text" class="form-control" placeholder="Search payments..." id="searchPayments">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="11" cy="11" r="8"/>
                                <path d="m21 21-4.35-4.35"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="table-container">
                    @if($payments->count() > 0)
                        <table class="payments-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Student</th>
                                    <th>Program</th>
                                    <th>Amount</th>
                                    <th>Expected</th>
                                    <th>Method</th>
                                    <th>Frequency</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($payments as $payment)
                                    <tr class="payment-row {{ $payment->status }}">
                                        <td>
                                            <span class="payment-id">#{{ $payment->id }}</span>
                                        </td>
                                        <td>
                                            <div class="student-info">
                                                <div class="student-name">{{ $payment->enrollment->user->name }}</div>
                                                <div class="student-email">{{ $payment->enrollment->user->email }}</div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="program-name">{{ $payment->enrollment->program->title }}</span>
                                        </td>
                                        <td>
                                            <span class="amount-cell">MWK {{ number_format($payment->amount_paid, 0) }}</span>
                                        </td>
                                        <td>
                                            <span class="expected-cell">MWK {{ number_format($payment->expected_amount ?? 0, 0) }}</span>
                                        </td>
                                        <td>
                                            <span class="method-badge {{ $payment->payment_method }}">
                                                {{ ucfirst($payment->payment_method) }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="frequency-badge">
                                                {{ ucfirst(str_replace('_', ' ', $payment->payment_frequency ?? 'one_time')) }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="date-cell">{{ \Carbon\Carbon::parse($payment->payment_date)->format('M d, Y') }}</span>
                                        </td>
                                        <td>
                                            <span class="status-badge {{ $payment->status }}">
                                                @if($payment->status == 'approved')
                                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                                                        <polyline points="22 4 12 14.01 9 11.01"/>
                                                    </svg>
                                                    Approved
                                                @elseif($payment->status == 'pending')
                                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                        <circle cx="12" cy="12" r="10"/>
                                                        <polyline points="12 6 12 12 16 14"/>
                                                    </svg>
                                                    Pending
                                                @else
                                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                        <circle cx="12" cy="12" r="10"/>
                                                        <line x1="15" y1="9" x2="9" y2="15"/>
                                                        <line x1="9" y1="9" x2="15" y2="15"/>
                                                    </svg>
                                                    Rejected
                                                @endif
                                            </span>
                                        </td>
                                        <td>
                                            <div class="action-buttons">
                                                <button class="btn-action btn-view" onclick="viewPayment({{ $payment->id }})">
                                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                                        <circle cx="12" cy="12" r="3"/>
                                                    </svg>
                                                </button>
                                                <button class="btn-action btn-edit" onclick="editPayment({{ $payment->id }})">
                                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                                    </svg>
                                                </button>
                                                <form action="{{ route('admin.payments.destroy', $payment->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this payment?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn-action btn-delete">
                                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                            <polyline points="3 6 5 6 21 6"/>
                                                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                                                        </svg>
                                                    </button>
                                                </form>
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
                                    <rect x="1" y="4" width="22" height="16" rx="2" ry="2"/>
                                    <line x1="1" y1="10" x2="23" y2="10"/>
                                </svg>
                            </div>
                            <h4>No Payments Found</h4>
                            <p>No payments have been recorded yet. Start by making your first payment.</p>
                            <a href="{{ route('admin.payments.create') }}" class="btn btn-primary">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <line x1="12" y1="5" x2="12" y2="19"/>
                                    <line x1="5" y1="12" x2="19" y2="12"/>
                                </svg>
                                Make First Payment
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Payment Details Modal -->
<div id="paymentModal" class="payment-modal" style="display: none;">
    <div class="payment-modal-content">
        <div class="payment-modal-header">
            <h4>Payment Details</h4>
            <button class="close-btn" onclick="closePaymentModal()">&times;</button>
        </div>
        <div class="payment-modal-body">
            <div class="payment-details-grid">
                <div class="detail-item">
                    <label>Payment ID</label>
                    <span id="modalPaymentId">#123</span>
                </div>
                <div class="detail-item">
                    <label>Student</label>
                    <span id="modalStudent">John Doe</span>
                </div>
                <div class="detail-item">
                    <label>Program</label>
                    <span id="modalProgram">Yoga Basics</span>
                </div>
                <div class="detail-item">
                    <label>Amount Paid</label>
                    <span id="modalAmount">MWK 120,000</span>
                </div>
                <div class="detail-item">
                    <label>Expected Amount</label>
                    <span id="modalExpected">MWK 120,000</span>
                </div>
                <div class="detail-item">
                    <label>Payment Method</label>
                    <span id="modalMethod">Mobile Money</span>
                </div>
                <div class="detail-item">
                    <label>Payment Frequency</label>
                    <span id="modalFrequency">Monthly</span>
                </div>
                <div class="detail-item">
                    <label>Payment Date</label>
                    <span id="modalDate">March 15, 2026</span>
                </div>
                <div class="detail-item">
                    <label>Status</label>
                    <span id="modalStatus">Approved</span>
                </div>
                <div class="detail-item full-width">
                    <label>Notes</label>
                    <span id="modalNotes">Payment for March yoga program</span>
                </div>
            </div>
            
            <div class="payment-actions">
                <button class="btn btn-primary" onclick="createNextPayment()">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="12" y1="5" x2="12" y2="19"/>
                        <line x1="5" y1="12" x2="19" y2="12"/>
                    </svg>
                    New Payment
                </button>
                <button class="btn btn-outline-primary" onclick="sendPaymentReminder()">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/>
                        <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
                    </svg>
                    Send Reminder
                </button>
            </div>
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

.payments-table-card {
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

.table-actions {
    display: flex;
    gap: 1rem;
}

.search-box {
    position: relative;
    display: flex;
    align-items: center;
}

.search-box input {
    background: var(--bg-tertiary);
    border: 1px solid var(--border-color);
    color: var(--text-primary);
    padding: 0.5rem 1rem 0.5rem 2.5rem;
    border-radius: 8px;
    font-size: 0.875rem;
    width: 250px;
}

.search-box svg {
    position: absolute;
    left: 0.75rem;
    color: var(--text-muted);
}

.table-container {
    overflow-x: auto;
}

.payments-table {
    width: 100%;
    border-collapse: collapse;
}

.payments-table th {
    background: var(--bg-tertiary);
    color: var(--text-secondary);
    font-weight: 600;
    text-align: left;
    padding: 1rem;
    font-size: 0.875rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.payments-table td {
    padding: 1rem;
    border-bottom: 1px solid var(--border-color);
    vertical-align: middle;
}

.payments-table tr:hover {
    background: var(--bg-tertiary);
}

.payment-id {
    font-weight: 600;
    color: var(--accent-lavender);
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

.amount-cell, .expected-cell {
    font-weight: 600;
    color: var(--success-color);
}

.method-badge, .frequency-badge {
    padding: 0.25rem 0.75rem;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 500;
    text-transform: capitalize;
}

.method-badge.mobile_money {
    background: rgba(16, 185, 129, 0.2);
    color: var(--success-color);
}

.method-badge.cash {
    background: rgba(245, 158, 11, 0.2);
    color: var(--warning-color);
}

.method-badge.bank {
    background: rgba(155, 89, 182, 0.2);
    color: var(--accent-lavender);
}

.frequency-badge {
    background: var(--bg-tertiary);
    color: var(--text-secondary);
}

.date-cell {
    color: var(--text-secondary);
    font-size: 0.875rem;
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

.status-badge.approved {
    background: rgba(16, 185, 129, 0.2);
    color: var(--success-color);
}

.status-badge.pending {
    background: rgba(245, 158, 11, 0.2);
    color: var(--warning-color);
}

.status-badge.rejected {
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
}

.btn-action:hover {
    background: var(--bg-tertiary);
    color: var(--text-primary);
}

.btn-action.btn-view:hover {
    border-color: var(--accent-lavender);
    color: var(--accent-lavender);
}

.btn-action.btn-edit:hover {
    border-color: var(--success-color);
    color: var(--success-color);
}

.btn-action.btn-delete:hover {
    border-color: var(--error-color);
    color: var(--error-color);
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
}

.empty-state h4 {
    color: var(--text-primary);
    margin-bottom: 0.5rem;
}

.empty-state p {
    margin-bottom: 2rem;
}

/* Payment Modal */
.payment-modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    z-index: 10000;
    display: flex;
    align-items: center;
    justify-content: center;
}

.payment-modal-content {
    background: var(--bg-secondary);
    border-radius: 16px;
    width: 90%;
    max-width: 600px;
    max-height: 80vh;
    overflow: hidden;
    border: 1px solid var(--border-color);
}

.payment-modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1.5rem;
    border-bottom: 1px solid var(--border-color);
}

.payment-modal-header h4 {
    color: var(--text-primary);
    margin: 0;
}

.close-btn {
    background: none;
    border: none;
    color: var(--text-secondary);
    font-size: 1.5rem;
    cursor: pointer;
    padding: 0;
    width: 30px;
    height: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    transition: all 0.3s ease;
}

.close-btn:hover {
    background: rgba(255, 255, 255, 0.1);
    color: var(--text-primary);
}

.payment-modal-body {
    padding: 2rem;
}

.payment-details-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.detail-item {
    display: flex;
    flex-direction: column;
}

.detail-item.full-width {
    grid-column: 1 / -1;
}

.detail-item label {
    color: var(--text-secondary);
    font-size: 0.875rem;
    font-weight: 500;
    margin-bottom: 0.5rem;
}

.detail-item span {
    color: var(--text-primary);
    font-weight: 600;
}

.payment-actions {
    display: flex;
    gap: 1rem;
    justify-content: flex-end;
}

.btn {
    padding: 0.75rem 1.5rem;
    border-radius: 8px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
    border: none;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.btn-primary {
    background: var(--accent-lavender);
    color: white;
}

.btn-primary:hover {
    background: var(--accent-lavender-dark);
}

.btn-outline-primary {
    background: transparent;
    color: var(--accent-lavender);
    border: 1px solid var(--accent-lavender);
}

.btn-outline-primary:hover {
    background: var(--accent-lavender);
    color: white;
}

@media (max-width: 768px) {
    .page-header {
        flex-direction: column;
        gap: 1rem;
        align-items: flex-start;
    }
    
    .payment-details-grid {
        grid-template-columns: 1fr;
    }
    
    .payment-actions {
        flex-direction: column;
    }
    
    .search-box input {
        width: 200px;
    }
}
</style>

<script>
// Payment data (in real app, this would come from the server)
const paymentsData = @json($payments->toArray());

function viewPayment(paymentId) {
    console.log('Viewing payment:', paymentId);
    console.log('Available payments:', paymentsData);
    
    const payment = paymentsData.find(p => p.id === paymentId);
    console.log('Found payment:', payment);
    
    if (payment) {
        document.getElementById('modalPaymentId').textContent = '#' + payment.id;
        document.getElementById('modalStudent').textContent = payment.enrollment.user.name;
        document.getElementById('modalProgram').textContent = payment.enrollment.program.title;
        document.getElementById('modalAmount').textContent = 'MWK ' + Number(payment.amount_paid).toLocaleString();
        document.getElementById('modalExpected').textContent = 'MWK ' + Number(payment.expected_amount || 0).toLocaleString();
        document.getElementById('modalMethod').textContent = payment.payment_method;
        document.getElementById('modalFrequency').textContent = payment.payment_frequency ? payment.payment_frequency.replace('_', ' ') : 'one_time';
        document.getElementById('modalDate').textContent = new Date(payment.payment_date).toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });
        document.getElementById('modalStatus').textContent = payment.status;
        document.getElementById('modalNotes').textContent = payment.notes || 'No notes provided';
        
        document.getElementById('paymentModal').style.display = 'block';
        console.log('Modal should be visible now');
    } else {
        console.error('Payment not found with ID:', paymentId);
        alert('Payment not found');
    }
}

function closePaymentModal() {
    document.getElementById('paymentModal').style.display = 'none';
}

function editPayment(paymentId) {
    console.log('Editing payment:', paymentId);
    // For now, just show an alert - can be expanded to open edit form
    alert('Edit payment feature coming soon! Payment ID: ' + paymentId);
}

function createNextPayment() {
    console.log('Creating next payment');
    // Redirect to payment creation page
    window.location.href = '{{ route('admin.payments.create') }}';
}

function sendPaymentReminder() {
    console.log('Sending payment reminder');
    // Send payment reminder (to be implemented)
    alert('Payment reminder feature coming soon!');
}

// Search functionality
document.getElementById('searchPayments').addEventListener('input', function(e) {
    const searchTerm = e.target.value.toLowerCase();
    const rows = document.querySelectorAll('.payment-row');
    
    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(searchTerm) ? '' : 'none';
    });
});

// Close modal when clicking outside
document.addEventListener('click', function(e) {
    const modal = document.getElementById('paymentModal');
    if (modal && modal.style.display === 'block' && !modal.contains(e.target)) {
        closePaymentModal();
    }
});

// Debug: Log when page loads
document.addEventListener('DOMContentLoaded', function() {
    console.log('Payments page loaded');
    console.log('Payments data:', paymentsData);
    
    // Test if modal exists
    const modal = document.getElementById('paymentModal');
    console.log('Modal element:', modal);
    
    // Test if view buttons exist
    const viewButtons = document.querySelectorAll('.btn-view');
    console.log('View buttons found:', viewButtons.length);
    
    // Add click listeners to all view buttons
    viewButtons.forEach((button, index) => {
        console.log('Adding click listener to button', index);
        button.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            const paymentId = parseInt(this.getAttribute('onclick').match(/\d+/)[0]);
            console.log('Button clicked, paymentId:', paymentId);
            viewPayment(paymentId);
        });
    });
    
    // Add click listeners to all edit buttons
    const editButtons = document.querySelectorAll('.btn-edit');
    editButtons.forEach((button, index) => {
        console.log('Adding click listener to edit button', index);
        button.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            const paymentId = parseInt(this.getAttribute('onclick').match(/\d+/)[0]);
            console.log('Edit button clicked, paymentId:', paymentId);
            editPayment(paymentId);
        });
    });
});
</script>
@endsection
