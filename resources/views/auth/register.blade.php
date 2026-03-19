<div class="yoga-auth-wrapper">
    <div class="yoga-card">

        <!-- Logo / Title -->
        <div class="yoga-card-header text-center">
            <div class="yoga-icon">🧘‍♀️</div>
            <h2>Becky Yoga Class</h2>
            <p>Begin your mindful journey</p>
        </div>

        <!-- Form -->
        <div class="yoga-card-body">

            @if (session('status'))
                <div class="alert alert-success text-center">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="form-group">
                    <label>Full Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" required>
                    @error('name') <small>{{ $message }}</small> @enderror
                </div>

                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" name="email" value="{{ old('email') }}" required>
                    @error('email') <small>{{ $message }}</small> @enderror
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" required>
                    @error('password') <small>{{ $message }}</small> @enderror
                </div>

                <div class="form-group">
                    <label>Confirm Password</label>
                    <input type="password" name="password_confirmation" required>
                </div>

                <button type="submit" class="yoga-btn">
                    Create Account
                </button>
            </form>

            <div class="text-center mt-3">
                <a href="{{ route('login') }}">Already a member? Log in</a>
            </div>

        </div>
    </div>
</div>
 

    <style>
body {
    margin: 0;
    font-family: 'Segoe UI', sans-serif;
    background: linear-gradient(135deg, #f6f5f2, #eef4f1);
}

/* Wrapper */
.yoga-auth-wrapper {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
}

/* Card */
.yoga-card {
    background: #ffffff;
    width: 100%;
    max-width: 420px;
    border-radius: 24px;
    box-shadow: 0 20px 40px rgba(0,0,0,0.08);
    overflow: hidden;
}

/* Header */
.yoga-card-header {
    padding: 40px 30px 30px;
    background: linear-gradient(135deg, #7b8f7b, #b7c9b7);
    color: #fff;
}

.yoga-icon {
    font-size: 42px;
    margin-bottom: 10px;
}

.yoga-card-header h2 {
    margin: 0;
    font-weight: 600;
}

.yoga-card-header p {
    font-size: 14px;
    opacity: 0.85;
}

/* Body */
.yoga-card-body {
    padding: 30px;
}

.form-group {
    margin-bottom: 18px;
}

.form-group label {
    display: block;
    font-size: 13px;
    color: #6b7280;
    margin-bottom: 6px;
}

.form-group input {
    width: 100%;
    padding: 12px 14px;
    border-radius: 12px;
    border: 1px solid #e5e7eb;
    background: #fafafa;
    font-size: 14px;
}

.form-group input:focus {
    outline: none;
    border-color: #7b8f7b;
    background: #fff;
}

.form-group small {
    color: #dc2626;
    font-size: 12px;
}

/* Button */
.yoga-btn {
    width: 100%;
    padding: 14px;
    border-radius: 14px;
    border: none;
    background: linear-gradient(135deg, #7b8f7b, #4f7f6d);
    color: #fff;
    font-size: 15px;
    font-weight: 600;
    cursor: pointer;
    margin-top: 10px;
}

.yoga-btn:hover {
    opacity: 0.95;
}

/* Link */
.yoga-card-body a {
    color: #4f7f6d;
    font-size: 14px;
    text-decoration: none;
}
</style>

 