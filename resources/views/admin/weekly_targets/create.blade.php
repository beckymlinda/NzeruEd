@extends('layouts.app')

@section('title', 'Set Weekly Target')

@section('content')
<div class="container py-5" style="max-width: 600px;">

    <h2 class="mb-4 text-success fw-bold">🎯 Set Weekly Target</h2>

    <!-- Success message -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <form action="{{ route('admin.weekly-targets.store') }}" method="POST">
        @csrf

        <!-- Select Program -->
        <div class="mb-3">
            <label for="program_id" class="form-label">Program</label>
            <select name="program_id" id="program_id" class="form-select">
                <option value="">-- Select Program --</option>
                @foreach($programs as $program)
                    <option value="{{ $program->id }}">{{ $program->title }}</option>
                @endforeach
            </select>
            @error('program_id') 
                <div class="text-danger small mt-1">{{ $message }}</div> 
            @enderror
        </div>

        <!-- Week Number -->
        <div class="mb-3">
            <label for="week_number" class="form-label">Week Number</label>
            <input type="number" name="week_number" id="week_number" min="1" max="12" class="form-control" placeholder="Week number (1-12)">
            @error('week_number') 
                <div class="text-danger small mt-1">{{ $message }}</div> 
            @enderror
        </div>

        <!-- Focus Area -->
        <div class="mb-3">
            <label for="focus_area" class="form-label">Focus Area</label>
            <input type="text" name="focus_area" id="focus_area" class="form-control" placeholder="E.g., Flexibility, Balance">
            @error('focus_area') 
                <div class="text-danger small mt-1">{{ $message }}</div> 
            @enderror
        </div>

        <!-- Description -->
        <div class="mb-3">
            <label for="description" class="form-label">Description / Guidance</label>
            <textarea name="description" id="description" rows="4" class="form-control" placeholder="Optional guidance or notes for the student"></textarea>
            @error('description') 
                <div class="text-danger small mt-1">{{ $message }}</div> 
            @enderror
        </div>

        <button type="submit" class="btn btn-success w-100">
            Save Weekly Target
        </button>
    </form>
</div>
@endsection
