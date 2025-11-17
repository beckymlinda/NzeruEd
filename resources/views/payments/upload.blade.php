@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Upload Payment Proof</h1>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('warning'))
        <div class="alert alert-warning">{{ session('warning') }}</div>
    @endif

    <form action="{{ route('payment.upload.submit') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="amount" class="form-label">Amount Paid (MWK)</label>
            <input type="number" name="amount" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="proof" class="form-label">Upload Proof (jpg, png, pdf)</label>
            <input type="file" name="proof" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Submit Payment Proof</button>
    </form>
</div>
@endsection
