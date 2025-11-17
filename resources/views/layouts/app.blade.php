{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'NzeruEd') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gradient-to-b from-yellow-50 via-yellow-100 to-yellow-50 min-h-screen text-gray-800">
    <div class="min-h-screen flex flex-col">
        {{-- Navigation --}}
        <nav class="bg-yellow-200 border-b border-yellow-300 shadow-md">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        {{-- Logo --}}
                        <div class="shrink-0 flex items-center">
                            <a href="{{ route('dashboard') }}" class="text-yellow-900 font-bold text-xl">
                                NzeruEd
                            </a>
                        </div>

                        {{-- Links --}}
                        <div class="hidden sm:-my-px sm:ml-10 sm:flex space-x-4">
                            @auth
                                <a href="{{ route('lessons.index') }}" class="px-3 py-2 rounded-md text-sm font-medium hover:bg-yellow-300 {{ request()->routeIs('lessons.*') ? 'bg-yellow-300' : '' }}">
                                    Lessons
                                </a>
                                <a href="{{ route('assignments.index', ['course'=>1]) }}" class="px-3 py-2 rounded-md text-sm font-medium hover:bg-yellow-300 {{ request()->routeIs('assignments.*') ? 'bg-yellow-300' : '' }}">
                                    Assignments
                                </a>
                                <a href="{{ route('payment.upload') }}" class="px-3 py-2 rounded-md text-sm font-medium hover:bg-yellow-300 {{ request()->routeIs('payment.upload') ? 'bg-yellow-300' : '' }}">
                                    Payments
                                </a>
                            @endauth
                        </div>
                    </div>

                    {{-- Profile / Logout --}}
                    <div class="hidden sm:flex sm:items-center sm:ml-6">
                        @auth
                            <div class="ml-3 relative">
                                <button type="button" class="flex items-center text-sm font-medium text-yellow-900 hover:text-yellow-800 focus:outline-none" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                                    <span>{{ Auth::user()->name }}</span>
                                    <svg class="ml-1 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>

                                {{-- Dropdown menu --}}
                                <div class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-yellow-50 ring-1 ring-black ring-opacity-5 focus:outline-none z-50 hidden" id="dropdown-menu">
                                    <div class="py-1">
                                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-yellow-900 hover:bg-yellow-100">Profile</a>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="w-full text-left px-4 py-2 text-sm text-yellow-900 hover:bg-yellow-100">
                                                Logout
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endauth
                    </div>

                    {{-- Mobile menu button --}}
                    <div class="-mr-2 flex items-center sm:hidden">
                        <button @click="open = !open" class="inline-flex items-center justify-center p-2 rounded-md text-yellow-900 hover:text-yellow-700 hover:bg-yellow-100 focus:outline-none">
                            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path :class="{'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                                <path :class="{'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 6l12 12M6 18L18 6"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </nav>

        {{-- Responsive Menu (optional, Tailwind + Alpine.js needed) --}}
        <div class="sm:hidden" x-show="open">
            @auth
                <a href="{{ route('lessons.index') }}" class="block px-4 py-2 text-sm text-yellow-900 hover:bg-yellow-100">Lessons</a>
                <a href="{{ route('assignments.index', ['course'=>1]) }}" class="block px-4 py-2 text-sm text-yellow-900 hover:bg-yellow-100">Assignments</a>
                <a href="{{ route('payment.upload') }}" class="block px-4 py-2 text-sm text-yellow-900 hover:bg-yellow-100">Payments</a>
            @endauth
        </div>

        {{-- Page Header --}}
        @isset($header)
            <header class="bg-yellow-50 shadow">
                <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        {{-- Page Content --}}
        <main class="flex-1">
            @yield('content')
        </main>
    </div>

    <script>
        // Simple dropdown toggle
        document.addEventListener('DOMContentLoaded', function() {
            const btn = document.getElementById('user-menu-button');
            const menu = document.getElementById('dropdown-menu');
            if(btn){
                btn.addEventListener('click', () => {
                    menu.classList.toggle('hidden');
                });
            }
        });
    </script>
</body>
</html>
