@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">

    <!-- Header -->
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-semibold text-gray-800">Admin – Student Progress</h1>
            <p class="text-sm text-gray-500">Manage attendance, poses, and weekly growth</p>
        </div>
    </div>

    <!-- Student Selector -->
    <div class="bg-white rounded-2xl shadow p-5 mb-6">
        <form method="GET" action="">
            <label class="text-sm text-gray-600">Select Student</label>
            <select class="mt-1 w-full rounded-xl border-gray-300">
                @foreach($students as $student)
                    <option value="{{ $student->id }}">{{ $student->name }}</option>
                @endforeach
            </select>
        </form>
    </div>

    <!-- Attendance Marking -->
    <div class="bg-white rounded-2xl shadow p-5 mb-6">
        <h3 class="font-semibold text-gray-700 mb-4">📅 Mark Attendance</h3>
        <form method="POST" action="{{ route('attendance.store') }}">
            @csrf
            <input type="hidden" name="enrollment_id" value="{{ $enrollment->id }}">

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <input type="date" name="session_date" class="rounded-xl border-gray-300" required>

                <select name="status" class="rounded-xl border-gray-300">
                    <option value="present">Present</option>
                    <option value="missed">Missed</option>
                </select>

                <input type="text" name="reason" placeholder="Reason if missed" class="rounded-xl border-gray-300">
            </div>

            <button class="mt-4 px-5 py-2 bg-green-600 text-white rounded-xl">Save Attendance</button>
        </form>
    </div>

    <!-- Weekly Progress Upload -->
    <div class="bg-white rounded-2xl shadow p-5 mb-6">
        <h3 class="font-semibold text-gray-700 mb-4">🧘 Weekly Progress</h3>
        <form method="POST" action="{{ route('weekly-progress.store') }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="enrollment_id" value="{{ $enrollment->id }}">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <input type="number" name="week_number" placeholder="Week number" class="rounded-xl border-gray-300" required>
                <textarea name="instructor_notes" placeholder="Instructor notes" class="rounded-xl border-gray-300"></textarea>

                <input type="number" name="flexibility_score" placeholder="Flexibility (1–10)" class="rounded-xl border-gray-300">
                <input type="number" name="strength_score" placeholder="Strength (1–10)" class="rounded-xl border-gray-300">
                <input type="number" name="balance_score" placeholder="Balance (1–10)" class="rounded-xl border-gray-300">
                <input type="number" name="mindset_score" placeholder="Mindset (1–10)" class="rounded-xl border-gray-300">
            </div>

            <textarea name="overall_feedback" placeholder="Overall feedback" class="mt-4 w-full rounded-xl border-gray-300"></textarea>

            <div class="mt-4">
                <label class="text-sm text-gray-600">Upload Best Pose (Photo/Video)</label>
                <input type="file" name="media" class="mt-1 w-full">
            </div>

            <button class="mt-4 px-5 py-2 bg-green-600 text-white rounded-xl">Save Weekly Progress</button>
        </form>
    </div>

    <!-- Achievements -->
    <div class="bg-white rounded-2xl shadow p-5">
        <h3 class="font-semibold text-gray-700 mb-4">🏅 Award Achievement</h3>
        <form method="POST" action="{{ route('student-achievements.store') }}">
            @csrf
            <input type="hidden" name="enrollment_id" value="{{ $enrollment->id }}">

            <select name="achievement_id" class="w-full rounded-xl border-gray-300 mb-3">
                @foreach($achievements as $achievement)
                    <option value="{{ $achievement->id }}">{{ $achievement->title }}</option>
                @endforeach
            </select>

            <input type="number" name="awarded_week" placeholder="Awarded Week" class="w-full rounded-xl border-gray-300 mb-3">

            <textarea name="notes" placeholder="Notes" class="w-full rounded-xl border-gray-300"></textarea>

            <button class="mt-4 px-5 py-2 bg-green-600 text-white rounded-xl">Award Badge</button>
        </form>
    </div>

</div>
@endsection
