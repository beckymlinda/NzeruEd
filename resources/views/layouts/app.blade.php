<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Yoga Studio')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body {
            min-height: 100vh;
            background-color: #1a1a1a;
        }

        /* Sidebar */
        .sidebar {
            width: 280px;
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            background: linear-gradient(180deg, #1a1a1a 0%, #2d2d2d 100%);
            border-right: 1px solid #4a4a4a;
            transition: transform 0.3s ease;
            z-index: 9999;
            display: flex;
            flex-direction: column;
        }

        .sidebar-header {
            padding: 1.5rem;
            border-bottom: 1px solid #4a4a4a;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .sidebar-logo {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .header-user-photo {
            display: flex;
            align-items: center;
        }

        .header-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid rgba(155, 89, 182, 0.5);
        }

        .header-avatar-fallback {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #9b59b6 0%, #8e44ad 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 0.875rem;
            border: 2px solid rgba(155, 89, 182, 0.5);
        }

        .logo-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #9b59b6 0%, #8e44ad 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }

        .logo-text h4 {
            font-size: 1.25rem;
            font-weight: 700;
            color: #ffffff;
        }

        .logo-text small {
            font-size: 0.75rem;
            color: #b8b8b8;
        }

        .sidebar-nav {
            flex: 1;
            padding: 1rem 0;
            overflow-y: auto;
        }

        .nav-section {
            margin-bottom: 2rem;
        }

        .nav-section-title {
            padding: 0 1.5rem 0.5rem;
            font-size: 0.75rem;
            font-weight: 600;
            color: #9b59b6;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .nav-item {
            display: flex;
            align-items: center;
            padding: 0.75rem 1.5rem;
            color: #e0e0e0;
            text-decoration: none;
            transition: all 0.2s ease;
            position: relative;
            font-weight: 500;
        }

        .nav-item:hover {
            background-color: #3a3a3a;
            color: #ffffff;
        }

        .nav-item.active {
            background-color: rgba(155, 89, 182, 0.1);
            color: #9b59b6;
        }

        .nav-item.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 3px;
            background: linear-gradient(180deg, #9b59b6 0%, #8e44ad 100%);
        }

        .nav-icon {
            width: 20px;
            height: 20px;
            margin-right: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #b8b8b8;
        }

        .nav-item:hover .nav-icon {
            color: #9b59b6;
        }

        .nav-item.active .nav-icon {
            color: #9b59b6;
        }

        .nav-badge {
            margin-left: auto;
            background: linear-gradient(135deg, #9b59b6 0%, #8e44ad 100%);
            color: white;
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
            border-radius: 12px;
            font-weight: 600;
            min-width: 20px;
            text-align: center;
        }

        .nav-dropdown-toggle {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            padding: 0.75rem 1.5rem;
            color: #e0e0e0;
            text-decoration: none;
            transition: all 0.2s ease;
            font-weight: 500;
        }

        .nav-dropdown-toggle:hover {
            background-color: #3a3a3a;
            color: #ffffff;
        }

        .nav-dropdown-arrow {
            transition: transform 0.2s ease;
        }

        .nav-dropdown-toggle[aria-expanded="true"] .nav-dropdown-arrow {
            transform: rotate(180deg);
        }

        .nav-dropdown-menu {
            background: #2d2d2d;
            border: 1px solid #4a4a4a;
            border-radius: 8px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.3);
            margin: 0.5rem 1rem;
            padding: 0.5rem 0;
            list-style: none;
        }

        .dropdown-menu {
            background: #2d2d2d;
            border: 1px solid #4a4a4a;
            border-radius: 8px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.3);
            margin: 0.5rem 1rem;
            padding: 0.5rem 0;
            list-style: none;
        }

        .dropdown-menu li {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .dropdown-item {
            display: flex;
            align-items: center;
            padding: 0.5rem 1rem;
            color: #e0e0e0;
            text-decoration: none;
            transition: all 0.2s ease;
            font-size: 0.875rem;
        }

        .dropdown-item:hover {
            background-color: #3a3a3a;
            color: #9b59b6;
        }

        .dropdown-item .nav-icon {
            width: 16px;
            height: 16px;
            margin-right: 0.5rem;
        }

        .sidebar-footer {
            padding: 1rem 1.5rem;
            border-top: 1px solid #4a4a4a;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #9b59b6 0%, #8e44ad 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 0.875rem;
            overflow: hidden;
            position: relative;
        }

        .user-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
        }

        .avatar-fallback {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 0.875rem;
        }

        .user-info {
            flex: 1;
        }

        .user-name {
            font-size: 0.875rem;
            font-weight: 600;
            color: #ffffff;
            line-height: 1.2;
        }

        .user-role {
            font-size: 0.75rem;
            color: #9b59b6;
            text-transform: capitalize;
        }

        /* Student-specific dark theme adjustments */
        .student-user .container,
        .student-user .card,
        .student-user .alert,
        .student-user .form-control,
        .student-user .form-select,
        .student-user .form-label {
            background-color: #2d2d2d !important;
            color: #ffffff !important;
            border-color: #4a4a4a !important;
        }

        .student-user h1,
        .student-user h2,
        .student-user h3,
        .student-user h4,
        .student-user h5,
        .student-user h6 {
            color: #ffffff !important;
        }

        .student-user .text-success {
            color: #10b981 !important;
        }

        .student-user .text-info {
            color: #9b59b6 !important;
        }

        .student-user .text-muted {
            color: #b8b8b8 !important;
        }

        .student-user .btn {
            background-color: #9b59b6 !important;
            border-color: #9b59b6 !important;
            color: #ffffff !important;
        }

        .student-user .btn:hover {
            background-color: #8e44ad !important;
            border-color: #8e44ad !important;
        }

        .student-user .btn-success {
            background-color: #10b981 !important;
            border-color: #10b981 !important;
        }

        .student-user .btn-success:hover {
            background-color: #059669 !important;
            border-color: #059669 !important;
        }

        .student-user .progress-bar {
            background-color: #9b59b6 !important;
        }

        .student-user .progress-bar.bg-success {
            background-color: #10b981 !important;
        }

        .student-user .card-img-top {
            border-bottom: 1px solid #4a4a4a !important;
        }

        .student-user hr {
            border-color: #4a4a4a !important;
        }

        .student-user a {
            color: #9b59b6 !important;
        }

        .student-user a:hover {
            color: #c39bd3 !important;
        }

        .student-user .bg-light {
            background-color: #3a3a3a !important;
        }

        .student-user .text-dark {
            color: #ffffff !important;
        }

        .student-user .border-success {
            border-color: #10b981 !important;
        }

        .student-user .bg-white {
            background-color: #2d2d2d !important;
        }

        .student-user .display-6 {
            color: #ffffff !important;
        }

        /* Main Content */
        .main-content {
            margin-left: 280px;
            padding: 20px;
            background-color: #1a1a1a;
            color: #ffffff;
        }

        /* Topbar */
        .topbar {
            background: #2d2d2d;
            border-bottom: 1px solid #4a4a4a;
            padding: 12px 20px;
            color: #ffffff;
        }

        /* Mobile */
        @media (max-width: 991px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
                padding: 15px;
            }

            .topbar {
                padding: 10px 15px;
                margin-bottom: 20px;
            }

            .sidebar-header {
                padding: 1rem;
                flex-direction: column;
                gap: 1rem;
            }

            .sidebar-logo {
                width: 100%;
                justify-content: center;
            }

            .header-user-photo {
                position: absolute;
                top: 10px;
                right: 10px;
            }

            .nav-item {
                padding: 1rem 1.5rem;
                font-size: 0.9rem;
            }

            .nav-section-title {
                padding: 0.5rem 1.5rem;
                font-size: 0.7rem;
            }

            .user-profile {
                flex-direction: column;
                text-align: center;
                gap: 0.75rem;
            }

            .user-info {
                text-align: center;
            }
        }

        @media (max-width: 576px) {
            .sidebar {
                width: 100%;
                max-width: 280px;
            }

            .main-content {
                padding: 10px;
            }

            .topbar {
                padding: 8px 10px;
            }

            .topbar h5 {
                font-size: 1rem;
            }

            .btn-outline-success, .btn-outline-danger {
                padding: 0.25rem 0.5rem;
                font-size: 0.8rem;
            }

            .header-avatar, .header-avatar-fallback {
                width: 35px;
                height: 35px;
                font-size: 0.75rem;
            }

            .logo-icon {
                width: 35px;
                height: 35px;
            }

            .logo-text h4 {
                font-size: 1.1rem;
            }

            .logo-text small {
                font-size: 0.7rem;
            }
        }
    </style>
</head>
<body class="{{ auth()->user()->role }}-user">

<!-- Sidebar -->
<aside class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <div class="sidebar-logo">
            <div class="logo-icon">
                <svg width="32" height="32" viewBox="0 0 32 32" fill="none">
                    <circle cx="16" cy="16" r="14" stroke="currentColor" stroke-width="2"/>
                    <path d="M16 8C13.8 8 12 9.8 12 12C12 14.2 13.8 16 16 16C18.2 16 20 14.2 20 12C20 9.8 18.2 8 16 8Z" fill="currentColor"/>
                    <path d="M8 24C8 20.5 11.5 17 16 17C20.5 17 24 20.5 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                </svg>
            </div>
            <div class="logo-text">
                <h4 class="mb-0">Yoga Fitness</h4>
                <small class="text-muted">Yoga Management</small>
            </div>
        </div>
        
        <!-- User Profile Photo in Header -->
        <div class="header-user-photo">
            @if(auth()->user()->profile_photo)
                <img src="{{ asset('storage/profile_photos/' . auth()->user()->profile_photo) }}" alt="Profile Photo" class="header-avatar">
            @else
                <div class="header-avatar-fallback">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
            @endif
        </div>
    </div>

    <nav class="sidebar-nav">
        {{-- STUDENT --}}
        @if(auth()->user()->role === 'student')
            <div class="nav-section">
                <div class="nav-section-title">Main</div>
                
                <a href="{{ route('student.dashboard') }}" class="nav-item">
                    <div class="nav-icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="3" width="18" height="18" rx="2" ry="2"/>
                            <line x1="9" y1="9" x2="15" y2="9"/>
                            <line x1="9" y1="15" x2="15" y2="15"/>
                        </svg>
                    </div>
                    <span>Dashboard</span>
                </a>
            </div>

            <div class="nav-section">
                <div class="nav-section-title">My Progress</div>
                
                <a href="{{ route('student.weekly-progress') }}" class="nav-item">
                    <div class="nav-icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="18" y1="20" x2="18" y2="10"/>
                            <line x1="12" y1="20" x2="12" y2="4"/>
                            <line x1="6" y1="20" x2="6" y2="14"/>
                        </svg>
                    </div>
                    <span>Weekly Progress</span>
                </a>

                <a href="{{ route('student.weekly-poses') }}" class="nav-item">
                    <div class="nav-icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 2L2 7v10c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V7l-10-5z"/>
                        </svg>
                    </div>
                    <span>Weekly Poses</span>
                </a>

                <a href="{{ route('student.assignments.index') }}" class="nav-item">
                    <div class="nav-icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                            <polyline points="14,2 14,8 20,8"/>
                            <line x1="16" y1="13" x2="8" y2="13"/>
                            <line x1="16" y1="17" x2="8" y2="17"/>
                            <polyline points="10,9 9,9 8,9"/>
                        </svg>
                    </div>
                    <span>Assignments</span>
                    @if(($newAssignmentsCount ?? 0) > 0)
                        <span class="nav-badge">{{ $newAssignmentsCount }}</span>
                    @endif
                </a>
            </div>

            <div class="nav-section">
                <div class="nav-section-title">Account</div>
                
                <a href="{{ route('student.attendance') }}" class="nav-item">
                    <div class="nav-icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                            <line x1="16" y1="2" x2="16" y2="6"/>
                            <line x1="8" y1="2" x2="8" y2="6"/>
                            <line x1="3" y1="10" x2="21" y2="10"/>
                        </svg>
                    </div>
                    <span>My Attendance</span>
                </a>

                <a href="{{ route('student.payment-history') }}" class="nav-item">
                    <div class="nav-icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="1" y="4" width="22" height="16" rx="2" ry="2"/>
                            <line x1="1" y1="10" x2="23" y2="10"/>
                        </svg>
                    </div>
                    <span>Payment History</span>
                </a>

                <a href="{{ route('student.profile') }}" class="nav-item">
                    <div class="nav-icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                            <circle cx="12" cy="7" r="4"/>
                        </svg>
                    </div>
                    <span>My Profile</span>
                </a>
            </div>
        @endif

        {{-- ADMIN --}}
        @if(auth()->user()->role === 'admin')
            <div class="nav-section">
                <div class="nav-section-title">Main</div>
                
                <a href="{{ route('admin.dashboard') }}" class="nav-item">
                    <div class="nav-icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="3" width="7" height="7"/>
                            <rect x="14" y="3" width="7" height="7"/>
                            <rect x="14" y="14" width="7" height="7"/>
                            <rect x="3" y="14" width="7" height="7"/>
                        </svg>
                    </div>
                    <span>Dashboard</span>
                </a>

                <a href="{{ route('admin.enrollments.create') }}" class="nav-item">
                    <div class="nav-icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                            <circle cx="8.5" cy="7" r="4"/>
                            <line x1="20" y1="8" x2="20" y2="14"/>
                            <line x1="23" y1="11" x2="17" y2="11"/>
                        </svg>
                    </div>
                    <span>Enroll Student</span>
                </a>
            </div>

            <div class="nav-section">
                <div class="nav-section-title">Attendance</div>
                
                <div class="dropdown">
                    <button class="nav-dropdown-toggle" type="button" id="attendanceDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="nav-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                                <line x1="16" y1="2" x2="16" y2="6"/>
                                <line x1="8" y1="2" x2="8" y2="6"/>
                                <line x1="3" y1="10" x2="21" y2="10"/>
                            </svg>
                        </div>
                        <span>Attendance</span>
                        <div class="nav-dropdown-arrow">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="6 9 12 15 18 9"/>
                            </svg>
                        </div>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="attendanceDropdown">
                        <li>
                            <a class="dropdown-item" href="{{ route('admin.attendance.create') }}">
                                <div class="nav-icon">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <line x1="12" y1="5" x2="12" y2="19"/>
                                        <line x1="5" y1="12" x2="19" y2="12"/>
                                    </svg>
                                </div>
                                <span>Record Attendance</span>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('admin.attendance.index') }}">
                                <div class="nav-icon">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                        <circle cx="12" cy="12" r="3"/>
                                    </svg>
                                </div>
                                <span>View Attendance</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="nav-section">
                <div class="nav-section-title">Curriculum</div>
                
                <a href="{{ route('admin.weekly-targets.index') }}" class="nav-item">
                    <div class="nav-icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"/>
                            <circle cx="12" cy="12" r="6"/>
                            <circle cx="12" cy="12" r="2"/>
                        </svg>
                    </div>
                    <span>Weekly Targets</span>
                </a>

                <a href="{{ route('admin.weekly-poses.index') }}" class="nav-item">
                    <div class="nav-icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 2L2 7v10c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V7l-10-5z"/>
                        </svg>
                    </div>
                    <span>Weekly Poses</span>
                </a>

                <a href="{{ route('admin.weekly-progress.index') }}" class="nav-item">
                    <div class="nav-icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="18" y1="20" x2="18" y2="10"/>
                            <line x1="12" y1="20" x2="12" y2="4"/>
                            <line x1="6" y1="20" x2="6" y2="14"/>
                        </svg>
                    </div>
                    <span>Weekly Progress</span>
                </a>
            </div>

            <div class="nav-section">
                <div class="nav-section-title">Management</div>
                
                <div class="nav-dropdown">
                    <button class="nav-item" type="button" id="paymentsDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="nav-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="1" y="4" width="22" height="16" rx="2" ry="2"/>
                                <line x1="1" y1="10" x2="23" y2="10"/>
                            </svg>
                        </div>
                        <span>Payments</span>
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="6 9 12 15 18 9"/>
                        </svg>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="paymentsDropdown">
                        <li>
                            <a class="dropdown-item" href="{{ route('admin.payments.create') }}">
                                <div class="nav-icon">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <line x1="12" y1="5" x2="12" y2="19"/>
                                        <line x1="5" y1="12" x2="19" y2="12"/>
                                    </svg>
                                </div>
                                <span>Make Payment</span>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('admin.payments.index') }}">
                                <div class="nav-icon">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                        <circle cx="12" cy="12" r="3"/>
                                    </svg>
                                </div>
                                <span>View Payments</span>
                            </a>
                        </li>
                    </ul>
                </div>

                <a href="{{ route('admin.payment-reminders.index') }}" class="nav-item">
                    <div class="nav-icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/>
                            <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
                        </svg>
                    </div>
                    <span>Payment Reminders</span>
                </a>

                <a href="{{ route('admin.achievements.store') }}" class="nav-item">
                    <div class="nav-icon">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="8" r="7"/>
                            <polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"/>
                        </svg>
                    </div>
                    <span>Achievements</span>
                </a>
            </div>
        @endif
    </nav>

    <div class="sidebar-footer">
        <div class="user-profile">
            <div class="user-avatar">
                @if(auth()->user()->profile_photo)
                    <img src="{{ asset('storage/profile_photos/' . auth()->user()->profile_photo) }}" alt="Profile Photo" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                    <div class="avatar-fallback" style="display: none;">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                @else
                    <div class="avatar-fallback">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                @endif
            </div>
            <div class="user-info">
                <div class="user-name">{{ auth()->user()->name }}</div>
                <div class="user-role">{{ ucfirst(auth()->user()->role) }}</div>
            </div>
        </div>
    </div>

    <!-- Notification Modal -->
    <div id="notificationModal" class="notification-modal" style="display: none;">
        <div class="notification-modal-content">
            <div class="notification-modal-header">
                <h4>Notifications</h4>
                <button class="close-btn" onclick="toggleNotifications()">&times;</button>
            </div>
            <div class="notification-modal-body">
                @php
                    $notifications = \App\Models\Notification::forUser(auth()->id())
                        ->orderBy('created_at', 'desc')
                        ->take(10)
                        ->get();
                @endphp
                @if($notifications->count() > 0)
                    @foreach($notifications as $notification)
                        <div class="notification-item {{ $notification->is_read ? 'read' : 'unread' }}" onclick="markNotificationAsRead({{ $notification->id }})">
                            <div class="notification-content">
                                <h5>{{ $notification->title }}</h5>
                                <p>{{ $notification->message }}</p>
                                @if($notification->data)
                                    <div class="notification-details">
                                        @if($notification->type == 'payment_reminder' || $notification->type == 'payment_due')
                                            @if(isset($notification->data['amount']))
                                                <span class="notification-amount">Amount: MWK {{ number_format($notification->data['amount'], 0) }}</span>
                                            @endif
                                            @if(isset($notification->data['due_date']))
                                                <span class="notification-date">Due: {{ \Carbon\Carbon::parse($notification->data['due_date'])->format('M d, Y') }}</span>
                                            @endif
                                        @elseif($notification->type == 'assignment' || $notification->type == 'assignment_reminder')
                                            @if(isset($notification->data['assignment_title']))
                                                <span class="notification-assignment">Assignment: {{ $notification->data['assignment_title'] }}</span>
                                            @endif
                                            @if(isset($notification->data['due_date']))
                                                <span class="notification-date">Due: {{ \Carbon\Carbon::parse($notification->data['due_date'])->format('M d, Y') }}</span>
                                            @endif
                                        @elseif($notification->type == 'weekly_pose' || $notification->type == 'weekly_pose_reminder')
                                            @if(isset($notification->data['pose_name']))
                                                <span class="notification-pose">Pose: {{ $notification->data['pose_name'] }}</span>
                                            @endif
                                            @if(isset($notification->data['week_number']))
                                                <span class="notification-week">Week {{ $notification->data['week_number'] }}</span>
                                            @endif
                                        @endif
                                    </div>
                                @endif
                            </div>
                            <div class="notification-time">
                                {{ $notification->created_at->diffForHumans() }}
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="no-notifications">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/>
                            <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
                        </svg>
                        <p>No notifications</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

</aside>

<!-- Main Content -->
<div class="main-content">

    <!-- Topbar -->
    <div class="topbar d-flex justify-content-between align-items-center mb-4">

        <div class="d-flex align-items-center gap-3">
            <!-- Mobile Toggle -->
            <button class="btn btn-outline-success d-lg-none"
                    onclick="toggleSidebar()">
                ☰
            </button>

            <h5 class="mb-0">@yield('title', 'Dashboard')</h5>
        </div>

        <div class="d-flex align-items-center gap-3">
            <!-- Notification Icon -->
            <div class="notification-wrapper">
                <button class="notification-btn" onclick="toggleNotifications()">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/>
                        <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
                    </svg>
                    @php
                        $unreadNotifications = \App\Models\Notification::forUser(auth()->id())->unread()->count();
                    @endphp
                    @if($unreadNotifications > 0)
                        <span class="notification-badge">{{ $unreadNotifications }}</span>
                    @endif
                </button>
            </div>

            <span class="text-muted">{{ auth()->user()->name }}</span>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-outline-danger btn-sm">
                    Logout
                </button>
            </form>
        </div>
    </div>

    <!-- Page Content -->
    <main>
        @yield('content')
    </main>

</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
    function toggleSidebar() {
        document.getElementById('sidebar').classList.toggle('show');
    }

    // Aggressive fix for stuck modal backdrops and overlays
    document.addEventListener('DOMContentLoaded', function() {
        // Force remove any stuck modal backdrops immediately
        function removeStuckOverlays() {
            // Remove any modal backdrops
            const backdrops = document.querySelectorAll('[class*="opacity-75"]');
            backdrops.forEach(function(backdrop) {
                const parent = backdrop.closest('.fixed');
                if (parent) {
                    parent.style.display = 'none';
                    parent.remove();
                }
            });

            // Remove any fixed overlays that might block clicks
            const overlays = document.querySelectorAll('.fixed.inset-0');
            overlays.forEach(function(overlay) {
                if (!overlay.querySelector('.sidebar')) {
                    overlay.style.display = 'none';
                    overlay.style.pointerEvents = 'none';
                }
            });

            // Ensure body is scrollable
            document.body.classList.remove('overflow-y-hidden');
            document.body.style.overflow = 'auto';

            // Ensure sidebar is clickable
            const sidebar = document.getElementById('sidebar');
            if (sidebar) {
                sidebar.style.pointerEvents = 'auto';
                sidebar.style.zIndex = '9999';
            }
        }

        // Run immediately
        removeStuckOverlays();

        // Run again after a short delay to catch any late-loading elements
        setTimeout(removeStuckOverlays, 100);
        setTimeout(removeStuckOverlays, 500);
        setTimeout(removeStuckOverlays, 1000);

        // Continuously check for and remove stuck overlays
        setInterval(removeStuckOverlays, 2000);
    });

    // Also close modals when clicking outside
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('fixed') && e.target.classList.contains('inset-0')) {
            const backdrops = document.querySelectorAll('[class*="opacity-75"]');
            backdrops.forEach(function(backdrop) {
                const parent = backdrop.closest('.fixed');
                if (parent) {
                    parent.style.display = 'none';
                    parent.remove();
                }
            });
            document.body.classList.remove('overflow-y-hidden');
        }
    });

    // Close sidebar when nav items are clicked on mobile
    document.addEventListener('DOMContentLoaded', function() {
        const navItems = document.querySelectorAll('.nav-item');
        const sidebar = document.getElementById('sidebar');
        
        navItems.forEach(function(item) {
            item.addEventListener('click', function() {
                // Only close sidebar on mobile screens
                if (window.innerWidth <= 991) {
                    sidebar.classList.remove('show');
                    document.body.style.overflow = 'auto';
                }
            });
        });
    });

    // Ensure sidebar is always clickable
    document.addEventListener('mouseover', function(e) {
        const sidebar = document.getElementById('sidebar');
        if (sidebar && sidebar.contains(e.target)) {
            sidebar.style.pointerEvents = 'auto';
            sidebar.style.zIndex = '9999';
        }
    });

    // Notification functions
    function toggleNotifications() {
        const modal = document.getElementById('notificationModal');
        if (modal.style.display === 'none' || modal.style.display === '') {
            modal.style.display = 'block';
        } else {
            modal.style.display = 'none';
        }
    }

    function markNotificationAsRead(notificationId) {
        fetch(`/notifications/${notificationId}/read`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Remove unread class and update badge
                const notificationItem = document.querySelector(`[onclick="markNotificationAsRead(${notificationId})"]`);
                if (notificationItem) {
                    notificationItem.classList.remove('unread');
                    notificationItem.classList.add('read');
                }
                
                // Update notification badge
                const badge = document.querySelector('.notification-badge');
                if (badge) {
                    const currentCount = parseInt(badge.textContent);
                    if (currentCount > 1) {
                        badge.textContent = currentCount - 1;
                    } else {
                        badge.style.display = 'none';
                    }
                }
            }
        })
        .catch(error => console.error('Error marking notification as read:', error));
    }

    // Close notification modal when clicking outside
    document.addEventListener('click', function(e) {
        const modal = document.getElementById('notificationModal');
        const notificationBtn = document.querySelector('.notification-btn');
        
        if (modal && modal.style.display === 'block' && 
            !modal.contains(e.target) && 
            !notificationBtn.contains(e.target)) {
            modal.style.display = 'none';
        }
    });
</script>

<!-- Notification Styles -->
<style>
.notification-wrapper {
    position: relative;
}

.notification-btn {
    background: none;
    border: none;
    color: var(--text-secondary);
    cursor: pointer;
    padding: 8px;
    border-radius: 8px;
    transition: all 0.3s ease;
    position: relative;
}

.notification-btn:hover {
    color: var(--text-primary);
    background: rgba(255, 255, 255, 0.1);
}

.notification-badge {
    position: absolute;
    top: 4px;
    right: 4px;
    background: var(--accent-lavender);
    color: white;
    border-radius: 50%;
    width: 18px;
    height: 18px;
    font-size: 0.7rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 2px solid var(--bg-secondary);
}

.notification-modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    z-index: 10000;
    display: flex;
    align-items: center;
    justify-content: center;
}

.notification-modal-content {
    background: var(--bg-secondary);
    border-radius: 12px;
    width: 90%;
    max-width: 500px;
    max-height: 80vh;
    overflow: hidden;
    border: 1px solid var(--border-color);
}

.notification-modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1.5rem;
    border-bottom: 1px solid var(--border-color);
}

.notification-modal-header h4 {
    color: var(--text-primary);
    margin: 0;
}

.close-btn {
    background: none;
    border: none;
    color: var(--text-secondary);
    font-size: 1.5rem;
    cursor: pointer;
    padding: 0;
    width: 30px;
    height: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    transition: all 0.3s ease;
}

.close-btn:hover {
    background: rgba(255, 255, 255, 0.1);
    color: var(--text-primary);
}

.notification-modal-body {
    max-height: 60vh;
    overflow-y: auto;
}

.notification-item {
    display: flex;
    padding: 1rem 1.5rem;
    border-bottom: 1px solid var(--border-color);
    cursor: pointer;
    transition: background 0.3s ease;
}

.notification-item:hover {
    background: var(--bg-tertiary);
}

.notification-item.unread {
    background: rgba(155, 89, 182, 0.1);
    border-left: 4px solid var(--accent-lavender);
}

.notification-item.read {
    opacity: 0.7;
}

.notification-content {
    flex: 1;
}

.notification-content h5 {
    color: var(--text-primary);
    margin: 0 0 0.5rem 0;
    font-size: 0.9rem;
    font-weight: 600;
}

.notification-content p {
    color: var(--text-secondary);
    margin: 0 0 0.5rem 0;
    font-size: 0.85rem;
    line-height: 1.4;
}

.notification-details {
    display: flex;
    gap: 1rem;
    margin-top: 0.5rem;
}

.notification-amount, .notification-date {
    font-size: 0.75rem;
    color: var(--text-muted);
}

.notification-assignment, .notification-pose {
    font-size: 0.75rem;
    color: var(--accent-lavender);
    font-weight: 500;
}

.notification-week {
    font-size: 0.75rem;
    color: var(--success-color);
    font-weight: 500;
}

.notification-time {
    color: var(--text-muted);
    font-size: 0.75rem;
    white-space: nowrap;
    margin-left: 1rem;
    align-self: flex-start;
}

.no-notifications {
    text-align: center;
    padding: 3rem 1.5rem;
    color: var(--text-secondary);
}

.no-notifications svg {
    width: 48px;
    height: 48px;
    margin-bottom: 1rem;
    opacity: 0.5;
}

.no-notifications p {
    margin: 0;
    font-size: 0.9rem;
}

@media (max-width: 768px) {
    .notification-modal-content {
        width: 95%;
        margin: 1rem;
    }
    
    .notification-item {
        padding: 0.75rem 1rem;
    }
    
    .notification-details {
        flex-direction: column;
        gap: 0.25rem;
    }
    
    .notification-time {
        margin-left: 0;
        margin-top: 0.5rem;
    }
}
</style>

</body>
</html>
