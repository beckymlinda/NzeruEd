@extends('layouts.app') {{-- Using your main app layout --}}

@section('title', 'Register')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header text-white text-center fw-bold" style="background: linear-gradient(90deg, #6a0dad, #1e90ff);">
                    {{ __('Register a New Account') }}
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <!-- Name -->
                        <div class="mb-3">
                            <label for="name" class="form-label fw-bold" style="color:#6a0dad;">{{ __('Name') }}</label>
                            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                                   class="form-control border-purple bg-light-purple text-dark-purple">
                            @error('name')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label fw-bold" style="color:#6a0dad;">{{ __('Email') }}</label>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required
                                   class="form-control border-purple bg-light-purple text-dark-purple">
                            @error('email')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="mb-3">
                            <label for="password" class="form-label fw-bold" style="color:#6a0dad;">{{ __('Password') }}</label>
                            <input id="password" type="password" name="password" required
                                   class="form-control border-purple bg-light-purple text-dark-purple">
                            @error('password')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label fw-bold" style="color:#6a0dad;">{{ __('Confirm Password') }}</label>
                            <input id="password_confirmation" type="password" name="password_confirmation" required
                                   class="form-control border-purple bg-light-purple text-dark-purple">
                            @error('password_confirmation')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-gradient text-white fw-bold"
                                    style="background: linear-gradient(90deg, #6a0dad, #1e90ff); border: none;">
                                {{ __('Register') }}
                            </button>
                        </div>

                        <p class="text-center mt-3">
                            <a href="{{ route('login') }}" class="text-decoration-none fw-bold" style="color:#6a0dad;">
                                {{ __('Already registered? Login') }}
                            </a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .border-purple { border-color: #6a0dad !important; }
    .bg-light-purple { background-color: #f3e6ff; }
    .text-dark-purple { color: #4b0082; }
</style>
@endsection
