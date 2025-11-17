<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f5f7ff;
        }

        /* Navbar */
        .navbar {
            background: #3b3b98; /* deep blue */
            color: #fff;
        }

        .navbar-brand {
            color: #9b59b6 !important; /* purple accent */
            font-weight: bold;
        }

        /* Sidebar */
        .sidebar {
            width: 220px;
            background: #2c3e50;
            position: fixed;
            top: 56px;
            bottom: 0;
            padding-top: 20px;
        }

        .sidebar a {
            color: #9b59b6;
            padding: 10px 20px;
            display: block;
            text-decoration: none;
        }

        .sidebar a.active, .sidebar a:hover {
            background: #3b3b98;
            color: #fff;
            border-radius: 5px;
        }

        /* Main content */
        .content-wrapper {
            margin-left: 220px;
            padding: 20px;
            margin-top: 56px;
        }

        .btn-theme {
            background: #3b3b98;
            color: #fff;
            border: none;
        }

        .btn-theme:hover {
            background: #9b59b6;
            color: #fff;
        }

        .card-theme {
            border-top: 3px solid #9b59b6;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <a class="navbar-brand ms-3" href="{{ route('admin.dashboard') }}">Admin Panel</a>
    </nav>

    <div class="sidebar">
        <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">Dashboard</a>
        <a href="{{ route('admin.courses.index') }}" class="{{ request()->routeIs('admin.courses.*') ? 'active' : '' }}">Courses</a>
        <a href="{{ route('admin.assignments.index') }}" class="{{ request()->routeIs('admin.assignments.*') ? 'active' : '' }}">Assignments</a>
        <a href="{{ route('admin.submissions.index') }}" class="{{ request()->routeIs('admin.submissions.*') ? 'active' : '' }}">Submissions</a>
    </div>

    <div class="content-wrapper">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
