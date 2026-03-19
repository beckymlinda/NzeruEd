<div class="yoga-auth-wrapper">
    <div class="yoga-card">

        <!-- Header -->
        <div class="yoga-card-header text-center">
            <div class="yoga-icon">🌿</div>
            <h2>Welcome Back</h2>
            <p>Continue your yoga journey</p>
        </div>

        <!-- Body -->
        <div class="yoga-card-body">

            @if (session('status'))
                <div class="alert alert-success text-center">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email -->
                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus>
                    @error('email') <small>{{ $message }}</small> @enderror
                </div>

                <!-- Password -->
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" required>
                    @error('password') <small>{{ $message }}</small> @enderror
                </div>

                <!-- Remember -->
                <div class="remember-row">
                    <label>
                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                        Remember me
                    </label>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}">Forgot password?</a>
                    @endif
                </div>

                <!-- Button -->
                <button type="submit" class="yoga-btn">
                    Log In
                </button>
            </form>

            <div class="text-center mt-3">
                <a href="{{ route('register') }}">New here? Create an account</a>
            </div>

        </div>
    </div>
</div>
 

 <style>
html {
    font-size: 16px;
}

body {
    margin: 0;
    font-family: 'Segoe UI', sans-serif;
    background: linear-gradient(135deg, #f4f6f3, #e8f0ec);
}

/* Wrapper */
.yoga-auth-wrapper {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 16px;
}

/* Card */
.yoga-card {
    width: 100%;
    max-width: 100%;
    background: #ffffff;
    border-radius: 22px;
    box-shadow: 0 20px 45px rgba(0,0,0,0.08);
    overflow: hidden;
}

/* Header */
.yoga-card-header {
    padding: 36px 24px;
    background: linear-gradient(135deg, #8faea3, #6f8f7f);
    color: #fff;
}

.yoga-icon {
    font-size: 42px;
    margin-bottom: 10px;
}

.yoga-card-header h2 {
    margin: 0;
    font-size: 1.6rem;
    font-weight: 600;
}

.yoga-card-header p {
    font-size: 1rem;
    opacity: 0.9;
}

/* Body */
.yoga-card-body {
    padding: 24px;
}

/* Inputs */
.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    font-size: 0.95rem;
    color: #6b7280;
    margin-bottom: 6px;
}

.form-group input {
    width: 100%;
    padding: 14px 16px;
    border-radius: 14px;
    border: 1px solid #e5e7eb;
    background: #fafafa;
    font-size: 16px; /* 🔑 prevents mobile zoom */
}

.form-group input:focus {
    outline: none;
    border-color: #6f8f7f;
    background: #fff;
}

.form-group small {
    color: #dc2626;
    font-size: 0.85rem;
}

/* Remember row */
.remember-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 0.95rem;
    margin-bottom: 24px;
}

.remember-row a {
    color: #6f8f7f;
    text-decoration: none;
}

/* Button */
.yoga-btn {
    width: 100%;
    padding: 16px;
    border-radius: 16px;
    border: none;
    background: linear-gradient(135deg, #6f8f7f, #4f7f6d);
    color: #fff;
    font-size: 1rem;
    font-weight: 600;
}

/* Links */
.yoga-card-body a {
    color: #4f7f6d;
    font-size: 0.95rem;
    text-decoration: none;
}

/* Desktop enhancement */
@media (min-width: 768px) {
    .yoga-card {
        max-width: 420px;
    }
}
</style>
