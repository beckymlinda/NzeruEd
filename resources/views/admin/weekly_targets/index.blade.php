@extends('layouts.app')

@section('title', 'Weekly Targets')

@section('content')
<div class="container mx-auto px-4 py-6">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6">
        <div>
            <h2 class="text-2xl font-semibold text-gray-700">🎯 Weekly Targets</h2>
            <p class="text-sm text-gray-500">
                Set focus and guidance for students each week
            </p>
        </div>

        <a href="{{ route('admin.weekly-targets.create') }}"
           class="mt-4 sm:mt-0 inline-block bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
            ➕ Add Weekly Target
        </a>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="bg-green-100 border border-green-200 text-green-800 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Empty State -->
    @if($targets->isEmpty())
        <div class="bg-white rounded-xl shadow p-6 text-center">
            <p class="text-gray-500 mb-2">🌱 No weekly targets set yet.</p>
            <p class="text-sm text-gray-400">
                Create weekly focus areas to guide students through their program.
            </p>
        </div>
    @else

    <!-- Targets List -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @foreach($targets as $target)
            <div class="bg-white rounded-2xl shadow p-5 relative">

                <!-- Header + Actions -->
                <div class="flex justify-between items-start mb-2">
                    <div>
                        <h3 class="font-semibold text-gray-700">
                            Week {{ $target->week_number }}
                        </h3>
                        <p class="text-sm text-green-600">
                            {{ $target->program->title ?? 'Program' }}
                        </p>
                    </div>

                    <!-- Delete Button -->
                    <form action="{{ route('admin.weekly-targets.destroy', $target->id) }}"
                          method="POST"
                          onsubmit="return confirm('Are you sure you want to delete this weekly target?');">
                        @csrf
                        @method('DELETE')

                        <button type="submit"
                                class="text-red-500 hover:text-red-700 text-sm font-semibold">
                            🗑️ Delete
                        </button>
                    </form>
                </div>

                <p class="text-sm text-gray-700 font-medium mb-1">
                    🎯 {{ $target->focus_area }}
                </p>

                <p class="text-xs text-gray-500">
                    {{ $target->description ?? 'No additional guidance provided.' }}
                </p>
            </div>
        @endforeach
    </div>

    @endif

</div>
@endsection
