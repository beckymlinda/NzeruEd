{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'NzeruEd') }}</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
  body {
    background: linear-gradient(to bottom, #f3e8ff, #d0f0ff); /* soft purple-blue blend */
    margin: 0;
    padding: 0;
  }

  /* Navbar */
  .navbar {
      background: linear-gradient(90deg, #6a0dad, #1e90ff); /* purple to blue */
      border-bottom: 2px solid #4b0082; /* deep purple border */
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 56px;
      z-index: 1050;
  }

  .navbar-brand {
      color: #ffffff !important;
      font-weight: bold;
  }

  /* Sidebar */
  .sidebar {
      width: 240px;
      background: linear-gradient(to bottom, #4b0082, #1e90ff); /* deep purple to blue */
      position: fixed;
      top: 56px;         /* below navbar */
      left: 0;
      bottom: 0;
      padding-top: 20px;
      color: #ffffff;
      z-index: 1040;
      border-right: 2px solid #6a0dad; /* border in purple */
  }

  .sidebar a {
      color: #ffffff !important;
      padding: 12px 20px;
      display: block;
      text-decoration: none;
  }

  .sidebar a:hover {
      background: rgba(106, 13, 173, 0.2); /* semi-transparent purple on hover */
  }

  /* MAIN CONTENT FIX (the important part) */
  .content-wrapper {
      margin-top: 56px;   /* pushes content below navbar */
      margin-left: 240px; /* pushes content to the right of sidebar */
      padding: 20px;
      min-height: calc(100vh - 56px);
  }

  .dropdown-menu {
      background: #d0f0ff; /* soft blue for dropdowns */
  }
</style>


</head>

<body>

<div class="d-flex">
    {{-- Sidebar --}}
    @auth
    <div class="sidebar p-3">
        <h4 class="text-center mb-4">Menu</h4>

        <a href="{{ route('lessons.index') }}" class="d-block py-2 px-3 mb-2 {{ request()->routeIs('lessons.*') ? 'bg-dark' : '' }}">
            Lessons
        </a>

        <a href="{{ route('courses.index') }}" 
   class="d-block py-2 px-3 mb-2 {{ request()->routeIs('courses.*') ? 'bg-dark' : '' }}">
    Courses
</a>


        <a href="{{ route('payment.upload') }}" class="d-block py-2 px-3 mb-2 {{ request()->routeIs('payment.upload') ? 'bg-dark' : '' }}">
            Payments
        </a>
    </div>
    @endauth

    {{-- Main Content Area --}}
    <div class="flex-grow-1">

        {{-- Top Navbar --}}
        <nav class="navbar navbar-expand-lg navbar-dark px-4 shadow-sm">
            <a class="navbar-brand" href="{{ route('dashboard') }}">NzeruEd</a>

            <div class="ms-auto">
                @auth
                    <div class="dropdown">
                        <button class="btn btn-outline-warning dropdown-toggle" type="button" data-bs-toggle="dropdown">
                       Hello    {{ Auth::user()->name }}
                        </button>

                        <ul class="dropdown-menu dropdown-menu-end mt-2">
                            <li>
                                <a class="dropdown-item" href="{{ route('profile.edit') }}">Profile</a>
                            </li>

                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button class="dropdown-item text-danger">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @endauth
            </div>
        </nav>

        {{-- Page Header --}}
        @isset($header)
            <div class="bg-light border-bottom py-3 px-4">
                {{ $header }}
            </div>
        @endisset

        {{-- Page Content --}}
        <main class="content-wrapper">
    @yield('content')
</main>


    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
