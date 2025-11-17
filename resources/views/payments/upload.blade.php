@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">

            {{-- Card --}}
            <div class="card shadow-sm border-0">
                <div class="card-header bg-dark text-gold">
                    <h3 class="mb-0">Upload Payment Proof</h3>
                </div>

                <div class="card-body">
                    {{-- Alerts --}}
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if(session('warning'))
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            {{ session('warning') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    {{-- Form --}}
                    <form action="{{ route('payment.upload.submit') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="amount" class="form-label">Amount Paid (MWK)</label>
                            <input type="number" name="amount" class="form-control form-control-lg" placeholder="Enter amount" required>
                        </div>

                        <div class="mb-3">
                            <label for="proof" class="form-label">Upload Proof (jpg, png, pdf)</label>
                            <input type="file" name="proof" class="form-control form-control-lg" required>
                        </div>

                        <button type="submit" class="btn btn-warning w-100 fw-bold">Submit Payment Proof</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<style>
    /* Text color */
    .text-gold {
        color: #6a0dad; /* deep purple from your theme */
    }

    /* Card header matches navbar gradient */
    .card-header {
        background: linear-gradient(90deg, #6a0dad, #1e90ff); /* purple → blue */
        border-bottom: 2px solid #6a0dad;
        color: white;
    }

    /* Buttons */
    .btn-warning {
        background: linear-gradient(90deg, #6a0dad, #1e90ff);
        border: none;
        color: white;
    }

    .btn-warning:hover {
        background: linear-gradient(90deg, #1e90ff, #6a0dad); /* reverse gradient on hover */
        color: white;
    }
</style>

@endsection
