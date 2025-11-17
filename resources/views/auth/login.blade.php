@extends('layouts.app') {{-- Assuming your main layout is layouts/app.blade.php --}}

@section('title', 'Login')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header text-white text-center fw-bold" style="background: linear-gradient(90deg, #6a0dad, #1e90ff);">
                    {{ __('Login to Your Account') }}
                </div>

                <div class="card-body">
                    <!-- Session Status -->
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label fw-bold" style="color:#6a0dad;">{{ __('Email') }}</label>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
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

                        <!-- Remember Me -->
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember" style="color:#1e90ff;">{{ __('Remember Me') }}</label>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-gradient text-white fw-bold" 
                                    style="background: linear-gradient(90deg, #6a0dad, #1e90ff); border: none;">
                                {{ __('Login') }}
                            </button>
                        </div>

                        @if (Route::has('password.request'))
                            <p class="mt-3 text-center">
                                <a href="{{ route('password.request') }}" class="text-decoration-none" style="color:#6a0dad;">
                                    {{ __('Forgot your password?') }}
                                </a>
                            </p>
                        @endif

                        <p class="text-center mt-2">
                            <a href="{{ route('register') }}" class="btn btn-outline-primary w-50" 
                               style="border-color:#6a0dad; color:#6a0dad;">
                                {{ __('Register') }}
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
