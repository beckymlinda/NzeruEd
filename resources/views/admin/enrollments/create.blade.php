@extends('layouts.app')

@section('title', 'Enroll Student')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-6">

            <div class="card shadow-sm border-0">
                <div class="card-body p-4">

                    <h4 class="mb-4 text-success fw-bold">
                        📝 Enroll Student into Program
                    </h4>

                    <form method="POST" action="{{ route('admin.enrollments.store') }}">
                        @csrf

                        <!-- Student -->
                        <div class="mb-3">
                            <label class="form-label">Student</label>
                            <select name="user_id" class="form-select" required>
                                <option value="">Select student</option>
                                @foreach($students as $student)
                                    <option value="{{ $student->id }}">
                                        {{ $student->name }} ({{ $student->email }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Program -->
                        <div class="mb-3">
                            <label class="form-label">Program</label>
                            <select name="program_id" id="program" class="form-select" required>
                                <option value="">Select program</option>
                                @foreach($programs as $program)
                                    <option value="{{ $program->id }}"
                                            data-weeks="{{ $program->duration_weeks }}">
                                        {{ $program->title }} ({{ $program->duration_weeks }} weeks)
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Start Date -->
                        <div class="mb-3">
                            <label class="form-label">Start Date</label>
                            <input
                                type="date"
                                name="start_date"
                                id="start_date"
                                class="form-control"
                                required
                            >
                        </div>

                        <!-- Expected End Date -->
                        <div class="mb-3">
                            <label class="form-label">Expected End Date</label>
                            <input
                                type="date"
                                name="expected_end_date"
                                id="expected_end_date"
                                class="form-control"
                                readonly
                            >
                            <small class="text-muted">
                                Automatically calculated based on program duration
                            </small>
                        </div>

                        <!-- Status -->
                        <div class="mb-4">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select" required>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-success w-100">
                            🌱 Enroll Student
                        </button>
                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

{{-- Auto-calculate end date --}}
<script>
    const programSelect = document.getElementById('program');
    const startDateInput = document.getElementById('start_date');
    const endDateInput = document.getElementById('expected_end_date');

    function calculateEndDate() {
        const selectedOption = programSelect.options[programSelect.selectedIndex];
        const weeks = selectedOption.getAttribute('data-weeks');
        const startDate = startDateInput.value;

        if (weeks && startDate) {
            const date = new Date(startDate);
            date.setDate(date.getDate() + (weeks * 7));
            endDateInput.value = date.toISOString().split('T')[0];
        }
    }

    programSelect.addEventListener('change', calculateEndDate);
    startDateInput.addEventListener('change', calculateEndDate);
</script>
@endsection
