@extends('layouts.app')

@section('title', 'Record Payment')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-8">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">
                    <i class="bi bi-credit-card text-primary"></i> Record Payment
                </h2>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">
                    ← Back to Dashboard
                </a>
            </div>

            <!-- Payment Form Card -->
            <div class="card shadow-sm border-0">
                <div class="card-header bg-gradient-primary text-white">
                    <h5 class="mb-0">💳 Payment Information</h5>
                </div>
                
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="bi bi-check-circle me-2"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.payments.store') }}" id="paymentForm">
                        @csrf

                        <!-- Student Selection -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-person me-2"></i>Student & Program
                                </label>
                                <select name="enrollment_id" class="form-select form-select-lg" id="enrollmentSelect" required>
                                    <option value="">Select student enrollment</option>
                                    @foreach($enrollments as $enrollment)
                                        <option value="{{ $enrollment->id }}" 
                                                data-expected="{{ $enrollment->program->fee ?? 0 }}"
                                                data-student="{{ $enrollment->user->name }}">
                                            {{ $enrollment->user->name }} — {{ $enrollment->program->title ?? 'Program' }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('enrollment_id') 
                                    <div class="text-danger mt-1">
                                        <i class="bi bi-exclamation-triangle"></i> {{ $message }}
                                    </div> 
                                @enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-calendar-event me-2"></i>Payment Date
                                </label>
                                <input type="date" name="payment_date" class="form-control form-control-lg" 
                                       value="{{ date('Y-m-d') }}" required>
                                @error('payment_date') 
                                    <div class="text-danger mt-1">
                                        <i class="bi bi-exclamation-triangle"></i> {{ $message }}
                                    </div> 
                                @enderror
                            </div>
                        </div>

                        <!-- Payment Details -->
                        <div class="row mb-4">
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-calculator me-2"></i>Expected Amount (MWK)
                                </label>
                                <input type="number" name="expected_amount" class="form-control form-control-lg" 
                                       placeholder="50000" min="100" step="100" id="expectedAmountInput" required>
                                @error('expected_amount') 
                                    <div class="text-danger mt-1">
                                        <i class="bi bi-exclamation-triangle"></i> {{ $message }}
                                    </div> 
                                @enderror
                            </div>
                            
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-cash-stack me-2"></i>Amount Paid (MWK)
                                </label>
                                <input type="number" name="amount_paid" class="form-control form-control-lg" 
                                       placeholder="5000" min="100" step="100" id="amountPaid" required>
                                @error('amount_paid') 
                                    <div class="text-danger mt-1">
                                        <i class="bi bi-exclamation-triangle"></i> {{ $message }}
                                    </div> 
                                @enderror
                            </div>
                            
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-credit-card me-2"></i>Payment Method
                                </label>
                                <select name="payment_method" class="form-select form-select-lg" required>
                                    <option value="">Select payment method</option>
                                    <option value="airtel_money">📱 Airtel Money</option>
                                    <option value="mpamba">📱 Mpamba</option>
                                    <option value="national_bank">🏦 National Bank</option>
                                    <option value="cash">💵 Cash</option>
                                    <option value="other">💳 Other</option>
                                </select>
                                @error('payment_method') 
                                    <div class="text-danger mt-1">
                                        <i class="bi bi-exclamation-triangle"></i> {{ $message }}
                                    </div> 
                                @enderror
                            </div>
                            
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-arrow-repeat me-2"></i>Payment Frequency
                                </label>
                                <select name="payment_frequency" class="form-select form-select-lg" id="paymentFrequency">
                                    <option value="one_time">One Time Payment</option>
                                    <option value="daily">Daily</option>
                                    <option value="weekly">Weekly</option>
                                    <option value="fortnightly">Fortnightly (2 weeks)</option>
                                    <option value="monthly">Monthly</option>
                                </select>
                            </div>
                        </div>

                        <!-- Balance Information -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="card bg-light border-0">
                                    <div class="card-body">
                                        <h6 class="card-title mb-3">
                                            <i class="bi bi-calculator me-2"></i>Balance Information
                                        </h6>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="d-flex align-items-center">
                                                    <div class="me-3">
                                                        <small class="text-muted">Expected Amount</small>
                                                        <div class="fw-bold text-primary" id="expectedAmount">MWK 0</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="d-flex align-items-center">
                                                    <div class="me-3">
                                                        <small class="text-muted">Amount Paid</small>
                                                        <div class="fw-bold text-success" id="paidAmount">MWK 0</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="d-flex align-items-center">
                                                    <div class="me-3">
                                                        <small class="text-muted">Remaining Balance</small>
                                                        <div class="fw-bold text-danger" id="remainingBalance">MWK 0</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Additional Information -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-journal-text me-2"></i>Notes (Optional)
                                </label>
                                <textarea name="notes" class="form-control" rows="3" 
                                          placeholder="Add any additional notes about this payment..."></textarea>
                                @error('notes') 
                                    <div class="text-danger mt-1">
                                        <i class="bi bi-exclamation-triangle"></i> {{ $message }}
                                    </div> 
                                @enderror
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary btn-lg">
                                <i class="bi bi-x-circle me-2"></i>Cancel
                            </a>
                            <button type="submit" class="btn btn-success btn-lg px-4">
                                <i class="bi bi-check-circle me-2"></i>Record Payment
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Custom Styles -->
<style>
.bg-gradient-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
}

.card {
    transition: transform 0.2s ease-in-out;
}

.card:hover {
    transform: translateY(-2px);
}

.form-control-lg {
    font-size: 1rem;
    padding: 0.75rem 1rem;
}

.form-select-lg {
    font-size: 1rem;
    padding: 0.75rem 1rem;
}

.btn-lg {
    padding: 0.75rem 2rem;
    font-size: 1rem;
    font-weight: 500;
}

.text-primary {
    color: #667eea !important;
}

.text-success {
    color: #10b981 !important;
}

.text-danger {
    color: #ef4444 !important;
}

.bg-light {
    background-color: #f8fafc !important;
}
</style>

<!-- JavaScript for Balance Calculation -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const expectedAmountInput = document.getElementById('expectedAmountInput');
    const amountPaidInput = document.getElementById('amountPaid');
    const expectedAmountEl = document.getElementById('expectedAmount');
    const paidAmountEl = document.getElementById('paidAmount');
    const remainingBalanceEl = document.getElementById('remainingBalance');

    function updateBalanceInfo() {
        const expectedAmount = parseFloat(expectedAmountInput.value) || 0;
        const amountPaid = parseFloat(amountPaidInput.value) || 0;
        const remainingBalance = expectedAmount - amountPaid;

        expectedAmountEl.textContent = `MWK ${expectedAmount.toLocaleString()}`;
        paidAmountEl.textContent = `MWK ${amountPaid.toLocaleString()}`;
        remainingBalanceEl.textContent = `MWK ${remainingBalance.toLocaleString()}`;

        // Update balance color based on amount
        if (remainingBalance <= 0) {
            remainingBalanceEl.className = 'fw-bold text-success';
            remainingBalanceEl.textContent = `MWK ${Math.abs(remainingBalance).toLocaleString()} (Credit)`;
        } else if (remainingBalance < expectedAmount * 0.5) {
            remainingBalanceEl.className = 'fw-bold text-warning';
        } else {
            remainingBalanceEl.className = 'fw-bold text-danger';
        }
    }

    expectedAmountInput.addEventListener('input', updateBalanceInfo);
    amountPaidInput.addEventListener('input', updateBalanceInfo);
});
</script>
@endsection
