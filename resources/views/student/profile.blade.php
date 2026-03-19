@extends('layouts.app')

@section('title', 'My Profile')

@section('content')
<div class="profile-wrapper">
    <div class="container-fluid py-4">
        <!-- Animated Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="page-header">
                    <div class="header-content">
                        <div class="header-left">
                            <div class="header-icon">
                                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                    <circle cx="12" cy="7" r="4"/>
                                </svg>
                            </div>
                            <div class="header-text">
                                <h1 class="page-title">My Profile</h1>
                                <p class="page-subtitle">Manage your personal information and account settings</p>
                            </div>
                        </div>
                        <div class="header-stats">
                            <div class="stat-card">
                                <div class="stat-value">{{ $enrollment ? 'Active' : 'None' }}</div>
                                <div class="stat-label">Enrollment</div>
                            </div>
                            @if($enrollment)
                                <div class="stat-card">
                                    <div class="stat-value">{{ $enrollment->program->title }}</div>
                                    <div class="stat-label">Program</div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                    <polyline points="22 4 12 14.01 9 11.01"/>
                </svg>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"/>
                    <line x1="15" y1="9" x2="9" y2="15"/>
                    <line x1="9" y1="9" x2="15" y2="15"/>
                </svg>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Profile Content -->
        <div class="row">
            <!-- Profile Photo & Basic Info -->
            <div class="col-lg-4 mb-4">
                <div class="profile-card">
                    <div class="profile-header">
                        <div class="profile-photo-container">
                            <div class="profile-photo">
                                @if($user->profile_photo)
                                    <img src="{{ asset('storage/profile_photos/' . $user->profile_photo) }}" alt="Profile Photo" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                    <div class="profile-avatar" style="display: none;">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                @else
                                    <div class="profile-avatar">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="profile-info">
                            <h3>{{ $user->name }}</h3>
                            <p class="profile-role">{{ ucfirst($user->role) }}</p>
                            @if($enrollment)
                                <div class="program-badge">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M12 2L2 7v10c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V7l-10-5z"/>
                                    </svg>
                                    {{ $enrollment->program->title }}
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Quick Stats -->
                    <div class="quick-stats">
                        @if($enrollment)
                                <div class="stat-item">
                                    <div class="stat-icon">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                                            <line x1="16" y1="2" x2="16" y2="6"/>
                                            <line x1="8" y1="2" x2="8" y2="6"/>
                                            <line x1="3" y1="10" x2="21" y2="10"/>
                                        </svg>
                                    </div>
                                    <div class="stat-details">
                                        <div class="stat-value">{{ $enrollment->attendance ? $enrollment->attendance->where('status', 'present')->count() : 0 }}</div>
                                        <div class="stat-label">Sessions Attended</div>
                                    </div>
                                </div>
                                <div class="stat-item">
                                    <div class="stat-icon">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <line x1="12" y1="1" x2="12" y2="23"/>
                                            <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
                                        </svg>
                                    </div>
                                    <div class="stat-details">
                                        <div class="stat-value">MWK {{ number_format($enrollment->payments ? $enrollment->payments->where('status', 'approved')->sum('amount_paid') : 0, 0) }}</div>
                                        <div class="stat-label">Total Paid</div>
                                    </div>
                                </div>
                            @endif
                    </div>
                </div>
            </div>

            <!-- Profile Forms -->
            <div class="col-lg-8 mb-4">
                <!-- Personal Information -->
                <div class="form-card">
                    <div class="card-header">
                        <h3>Personal Information</h3>
                        <div class="header-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('student.profile.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label">Full Name</label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" required>
                                    @error('name')
                                        <div class="error-message">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">Email Address</label>
                                    <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" required>
                                    @error('email')
                                        <div class="error-message">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="phone" class="form-label">Phone Number</label>
                                    <input type="tel" class="form-control" id="phone" name="phone" value="{{ $user->phone ?? '' }}">
                                    @error('phone')
                                        <div class="error-message">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="profile_photo" class="form-label">Profile Photo</label>
                                    <input type="file" id="profile_photo" name="profile_photo" accept="image/*" class="form-control" onchange="previewPhoto(event)">
                                    @error('profile_photo')
                                        <div class="error-message">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <label for="joined_date" class="form-label">Member Since</label>
                                    <input type="text" class="form-control" id="joined_date" value="{{ $user->created_at->format('F d, Y') }}" readonly>
                                </div>
                            </div>
                            <div class="form-actions">
                                <button type="submit" class="btn-primary">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/>
                                        <polyline points="17,21 17,13 7,13 7,21"/>
                                        <polyline points="7,3 7,8 15,8"/>
                                    </svg>
                                    Save Changes
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Change Password -->
                <div class="form-card">
                    <div class="card-header">
                        <h3>Change Password</h3>
                        <div class="header-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                            </svg>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('student.profile.change-password') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="current_password" class="form-label">Current Password</label>
                                <input type="password" class="form-control" id="current_password" name="current_password" required>
                                @error('current_password')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="password" class="form-label">New Password</label>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                    @error('password')
                                        <div class="error-message">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="password_confirmation" class="form-label">Confirm New Password</label>
                                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                                    @error('password_confirmation')
                                        <div class="error-message">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="password-requirements">
                                <h6>Password Requirements:</h6>
                                <ul>
                                    <li>At least 8 characters long</li>
                                    <li>Contains uppercase and lowercase letters</li>
                                    <li>Contains at least one number</li>
                                    <li>Contains at least one special character</li>
                                </ul>
                            </div>
                            <div class="form-actions">
                                <button type="submit" class="btn-primary">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                                        <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                                    </svg>
                                    Change Password
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Professional Styles -->
<style>
:root {
    --bg-primary: #0f0f0f;
    --bg-secondary: #1a1a1a;
    --bg-tertiary: #2a2a2a;
    --text-primary: #ffffff;
    --text-secondary: #b8b8b8;
    --text-muted: #888888;
    --accent-lavender: #9b59b6;
    --accent-lavender-light: #c39bd3;
    --accent-lavender-dark: #8e44ad;
    --success-color: #10b981;
    --warning-color: #f59e0b;
    --danger-color: #ef4444;
    --border-color: #3a3a3a;
}

.profile-wrapper {
    background: linear-gradient(135deg, var(--bg-primary) 0%, #1a1a2e 100%);
    min-height: 100vh;
    color: var(--text-primary);
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
}

/* Animated Header */
.page-header {
    background: linear-gradient(135deg, var(--accent-lavender) 0%, var(--accent-lavender-dark) 100%);
    border-radius: 20px;
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: 0 20px 40px rgba(155, 89, 182, 0.3);
    position: relative;
    overflow: hidden;
}

.page-header::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -10%;
    width: 300px;
    height: 300px;
    background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
    border-radius: 50%;
    animation: float 6s ease-in-out infinite;
}

@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-20px); }
}

.header-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
    position: relative;
    z-index: 1;
}

.header-left {
    display: flex;
    align-items: center;
    gap: 1.5rem;
}

.header-icon {
    background: rgba(255, 255, 255, 0.2);
    border-radius: 16px;
    padding: 1rem;
    display: flex;
    align-items: center;
    justify-content: center;
    backdrop-filter: blur(10px);
}

.header-icon svg {
    stroke: white;
}

.page-title {
    font-size: 2.5rem;
    font-weight: 800;
    margin-bottom: 0.5rem;
    background: linear-gradient(135deg, #ffffff 0%, rgba(255,255,255,0.8) 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.page-subtitle {
    font-size: 1.1rem;
    color: rgba(255, 255, 255, 0.9);
    margin-bottom: 0;
}

.header-stats {
    display: flex;
    gap: 1rem;
}

.stat-card {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    border-radius: 16px;
    padding: 1.5rem;
    text-align: center;
    min-width: 120px;
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.stat-value {
    font-size: 1.5rem;
    font-weight: 700;
    color: white;
    margin-bottom: 0.25rem;
}

.stat-label {
    font-size: 0.875rem;
    color: rgba(255, 255, 255, 0.8);
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

/* Alerts */
.alert {
    border-radius: 12px;
    border: none;
    padding: 1rem 1.5rem;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.alert-success {
    background: rgba(16, 185, 129, 0.2);
    color: var(--success-color);
    border: 1px solid rgba(16, 185, 129, 0.3);
}

.alert-danger {
    background: rgba(239, 68, 68, 0.2);
    color: var(--danger-color);
    border: 1px solid rgba(239, 68, 68, 0.3);
}

.alert svg {
    flex-shrink: 0;
}

.btn-close {
    color: inherit;
    opacity: 0.8;
}

/* Profile Card */
.profile-card {
    background: var(--bg-secondary);
    border-radius: 20px;
    padding: 2rem;
    border: 1px solid var(--border-color);
    height: 100%;
}

.profile-header {
    text-align: center;
    margin-bottom: 2rem;
}

.profile-photo-container {
    position: relative;
    margin-bottom: 1.5rem;
}

.profile-photo {
    width: 150px;
    height: 150px;
    border-radius: 50%;
    margin: 0 auto 1rem;
    overflow: hidden;
    border: 4px solid var(--accent-lavender);
    position: relative;
}

.profile-photo img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.profile-avatar {
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, var(--accent-lavender), var(--accent-lavender-dark));
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 3rem;
    font-weight: 700;
    color: white;
}

.photo-upload {
    position: absolute;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%);
}

.upload-btn {
    background: var(--accent-lavender);
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.875rem;
    font-weight: 600;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.3s ease;
}

.upload-btn:hover {
    background: var(--accent-lavender-dark);
    transform: translateY(-2px);
}

.profile-info h3 {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--text-primary);
    margin-bottom: 0.5rem;
}

.profile-role {
    color: var(--text-secondary);
    margin-bottom: 1rem;
}

.program-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    background: rgba(155, 89, 182, 0.2);
    color: var(--accent-lavender);
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.875rem;
    font-weight: 600;
}

/* Quick Stats */
.quick-stats {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.stat-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    background: var(--bg-tertiary);
    border-radius: 12px;
    border-left: 3px solid var(--accent-lavender);
}

.stat-icon {
    background: var(--accent-lavender);
    color: white;
    width: 40px;
    height: 40px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.stat-details {
    flex: 1;
}

.stat-details .stat-value {
    font-size: 1.1rem;
    font-weight: 700;
    color: var(--text-primary);
    margin-bottom: 0.25rem;
}

.stat-details .stat-label {
    font-size: 0.875rem;
    color: var(--text-secondary);
    margin-bottom: 0;
}

/* Form Cards */
.form-card {
    background: var(--bg-secondary);
    border-radius: 20px;
    padding: 2rem;
    border: 1px solid var(--border-color);
    margin-bottom: 2rem;
}

.card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid var(--border-color);
}

.card-header h3 {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--text-primary);
    margin: 0;
}

.header-icon {
    background: var(--bg-tertiary);
    color: var(--accent-lavender);
    width: 40px;
    height: 40px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* Form Styles */
.form-label {
    color: var(--text-secondary);
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.form-control {
    background: var(--bg-tertiary);
    border: 1px solid var(--border-color);
    color: var(--text-primary);
    border-radius: 10px;
    padding: 0.75rem 1rem;
    transition: all 0.3s ease;
}

.form-control:focus {
    background: var(--bg-tertiary);
    border-color: var(--accent-lavender);
    color: var(--text-primary);
    box-shadow: 0 0 0 0.2rem rgba(155, 89, 182, 0.25);
}

.form-control::placeholder {
    color: var(--text-muted);
}

.error-message {
    color: var(--danger-color);
    font-size: 0.875rem;
    margin-top: 0.25rem;
}

/* Password Requirements */
.password-requirements {
    background: var(--bg-tertiary);
    border-radius: 12px;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
}

.password-requirements h6 {
    color: var(--text-primary);
    font-weight: 600;
    margin-bottom: 1rem;
}

.password-requirements ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.password-requirements li {
    color: var(--text-secondary);
    font-size: 0.875rem;
    margin-bottom: 0.5rem;
    padding-left: 1.5rem;
    position: relative;
}

.password-requirements li::before {
    content: '✓';
    position: absolute;
    left: 0;
    color: var(--accent-lavender);
    font-weight: 600;
}

/* Form Actions */
.form-actions {
    display: flex;
    justify-content: flex-end;
    gap: 1rem;
    margin-top: 2rem;
}

.btn-primary {
    background: var(--accent-lavender);
    color: white;
    border: none;
    padding: 0.75rem 2rem;
    border-radius: 10px;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    background: var(--accent-lavender-dark);
    transform: translateY(-2px);
    box-shadow: 0 10px 20px rgba(155, 89, 182, 0.3);
}

/* Responsive */
@media (max-width: 768px) {
    .header-content {
        flex-direction: column;
        gap: 1.5rem;
        text-align: center;
    }
    
    .header-left {
        flex-direction: column;
        gap: 1rem;
    }
    
    .page-title {
        font-size: 2rem;
    }
    
    .profile-photo {
        width: 120px;
        height: 120px;
    }
    
    .form-actions {
        flex-direction: column;
    }
    
    .btn-primary {
        width: 100%;
        justify-content: center;
    }
}
</style>

<!-- JavaScript -->
<script>
function previewPhoto(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const profilePhoto = document.querySelector('.profile-photo');
            profilePhoto.innerHTML = `<img src="${e.target.result}" alt="Profile Photo" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                    <div class="profile-avatar" style="display: none;">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>`;
        }
        reader.readAsDataURL(file);
    }
}

// Handle form submission and refresh page
document.addEventListener('DOMContentLoaded', function() {
    const profileForm = document.querySelector('form[action*="profile/update"]');
    if (profileForm) {
        profileForm.addEventListener('submit', function(e) {
            // Show loading state
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg> Saving...';
            submitBtn.disabled = true;
            
            // Let the form submit normally, but add a small delay to show loading
            setTimeout(() => {
                // Form will submit and page will refresh naturally
            }, 500);
        });
    }
    
    // Animate cards on scroll
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, { threshold: 0.1 });
    
    document.querySelectorAll('.profile-card, .form-card').forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        card.style.transition = 'all 0.6s ease';
        observer.observe(card);
    });
});
</script>
@endsection
