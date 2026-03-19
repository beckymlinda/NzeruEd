@extends('layouts.app')

@section('title', 'Weekly Progress Records')

@section('content')
<div class="container py-4 max-w-6xl">

    <h2 class="mb-4 fw-semibold">📈 Weekly Progress Records</h2>

    <a href="{{ route('admin.weekly-progress.create') }}" class="btn btn-success mb-3">
        ➕ Add Weekly Progress
    </a>

    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Student</th>
                <th>Program</th>
                <th>Week</th>
                <th>Flexibility</th>
                <th>Strength</th>
                <th>Balance</th>
                <th>Mindset</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($weeklyProgresses as $progress)
            <tr>
                <td>{{ $progress->enrollment->user->name ?? 'Student' }}</td>
                <td>{{ $progress->enrollment->program->title ?? 'Program' }}</td>
                <td>{{ $progress->week_number }}</td>
                <td>{{ $progress->flexibility_score ?? '-' }}</td>
                <td>{{ $progress->strength_score ?? '-' }}</td>
                <td>{{ $progress->balance_score ?? '-' }}</td>
                <td>{{ $progress->mindset_score ?? '-' }}</td>
                <td>
                    <a href="#" class="btn btn-sm btn-primary">Edit</a>
                    <form action="#" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
