<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Medical Case Management' }} — Jajal Medical</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts & Styles via Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full font-sans antialiased text-slate-800 bg-slate-50" x-data="{ mobileSidebarOpen: false }">
    <div class="min-h-full flex flex-col lg:flex-row">

        <!-- Mobile Header Bar -->
        <header class="lg:hidden bg-white border-b border-slate-200 sticky top-0 z-40 px-4 py-3 flex items-center justify-between shadow-sm">
            <div class="flex items-center gap-3">
                <div class="h-9 w-9 rounded-lg bg-teal-600 flex items-center justify-center text-white font-bold shadow-md shadow-teal-500/20">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                </div>
                <div>
                    <span class="font-bold text-slate-900 tracking-tight text-base">Jajal Medical</span>
                    <span class="block text-[10px] uppercase font-semibold text-teal-600 tracking-wider">Case Management</span>
                </div>
            </div>

            <button @click="mobileSidebarOpen = !mobileSidebarOpen" type="button" class="p-2 rounded-lg text-slate-600 hover:text-slate-900 hover:bg-slate-100 focus:outline-none focus:ring-2 focus:ring-teal-500">
                <svg x-show="!mobileSidebarOpen" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
                <svg x-show="mobileSidebarOpen" x-cloak class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </header>

        <!-- Mobile Drawer Overlay -->
        <div x-show="mobileSidebarOpen" x-cloak class="fixed inset-0 z-50 lg:hidden flex">
            <div @click="mobileSidebarOpen = false" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity"></div>

            <div class="relative flex-1 flex flex-col max-w-xs w-full bg-white shadow-xl z-10">
                <div class="p-4 border-b border-slate-100 flex items-center justify-between">
                    <div class="flex items-center gap-2.5">
                        <div class="h-8 w-8 rounded-lg bg-teal-600 flex items-center justify-center text-white font-bold">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                        </div>
                        <span class="font-bold text-slate-900">Jajal Medical</span>
                    </div>
                    <button @click="mobileSidebarOpen = false" class="p-1 rounded-md text-slate-400 hover:text-slate-600">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <nav class="flex-1 px-4 py-4 space-y-1.5 overflow-y-auto">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('dashboard') ? 'bg-teal-50 text-teal-700 font-semibold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                        <svg class="w-5 h-5 {{ request()->routeIs('dashboard') ? 'text-teal-600' : 'text-slate-400' }}" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
                        </svg>
                        Dashboard
                    </a>

                    <a href="{{ route('cases.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('cases.index') || request()->routeIs('cases.show') || request()->routeIs('cases.edit') ? 'bg-teal-50 text-teal-700 font-semibold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                        <svg class="w-5 h-5 {{ request()->routeIs('cases.*') && !request()->routeIs('cases.create') ? 'text-teal-600' : 'text-slate-400' }}" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        All Cases
                    </a>

                    @can('create', App\Models\MedicalCase::class)
                        <a href="{{ route('cases.create') }}" class="flex items-center justify-between px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('cases.create') ? 'bg-teal-50 text-teal-700 font-semibold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                            <div class="flex items-center gap-3">
                                <svg class="w-5 h-5 {{ request()->routeIs('cases.create') ? 'text-teal-600' : 'text-slate-400' }}" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                </svg>
                                <span>Create Case</span>
                            </div>
                            <span class="text-[10px] font-bold px-1.5 py-0.5 rounded bg-blue-100 text-blue-800">Admin</span>
                        </a>
                    @endcan

                    <div class="pt-4 mt-4 border-t border-slate-100">
                        <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('profile.edit') ? 'bg-teal-50 text-teal-700 font-semibold' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                            <svg class="w-5 h-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                            </svg>
                            User Profile
                        </a>

                        <form method="POST" action="{{ route('logout') }}" class="mt-1">
                            @csrf
                            <button type="submit" class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-rose-600 hover:bg-rose-50 transition-colors">
                                <svg class="w-5 h-5 text-rose-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
                                </svg>
                                Log Out
                            </button>
                        </form>
                    </div>
                </nav>
            </div>
        </div>

        <!-- Desktop Persistent Sidebar -->
        <aside class="hidden lg:flex lg:flex-col lg:w-72 lg:fixed lg:inset-y-0 bg-white border-r border-slate-200 z-30">
            <!-- Brand Logo -->
            <div class="h-20 flex items-center px-6 border-b border-slate-100 gap-3.5">
                <div class="h-11 w-11 rounded-xl bg-gradient-to-tr from-teal-700 to-teal-500 flex items-center justify-center text-white shadow-md shadow-teal-600/20">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                </div>
                <div>
                    <h1 class="font-extrabold text-slate-900 text-lg leading-tight tracking-tight">Jajal Medical</h1>
                    <p class="text-xs font-semibold text-teal-600 tracking-wide uppercase">Case Management</p>
                </div>
            </div>

            <!-- Navigation Links -->
            <div class="flex-1 flex flex-col justify-between overflow-y-auto px-4 py-6">
                <div>
                    <div class="text-[11px] font-bold uppercase tracking-wider text-slate-400 px-3 mb-3">
                        Workspace
                    </div>
                    <nav class="space-y-1.5">
                        <a href="{{ route('dashboard') }}" class="group flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('dashboard') ? 'bg-teal-600 text-white shadow-sm shadow-teal-600/30 font-semibold' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                            <svg class="w-5 h-5 {{ request()->routeIs('dashboard') ? 'text-white' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
                            </svg>
                            Dashboard
                        </a>

                        <a href="{{ route('cases.index') }}" class="group flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('cases.index') || request()->routeIs('cases.show') || request()->routeIs('cases.edit') ? 'bg-teal-600 text-white shadow-sm shadow-teal-600/30 font-semibold' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                            <svg class="w-5 h-5 {{ request()->routeIs('cases.*') && !request()->routeIs('cases.create') ? 'text-white' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            All Cases
                        </a>

                        @can('create', App\Models\MedicalCase::class)
                            <a href="{{ route('cases.create') }}" class="group flex items-center justify-between px-3.5 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('cases.create') ? 'bg-teal-600 text-white shadow-sm shadow-teal-600/30 font-semibold' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                                <div class="flex items-center gap-3">
                                    <svg class="w-5 h-5 {{ request()->routeIs('cases.create') ? 'text-white' : 'text-slate-400 group-hover:text-slate-600' }}" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                    </svg>
                                    <span>Create Case</span>
                                </div>
                                <span class="text-[10px] uppercase font-bold px-1.5 py-0.5 rounded {{ request()->routeIs('cases.create') ? 'bg-white/20 text-white' : 'bg-blue-50 text-blue-700 border border-blue-200' }}">Admin</span>
                            </a>
                        @endcan
                    </nav>
                </div>

                <!-- User Profile & Session Card -->
                <div class="pt-6 border-t border-slate-100">
                    <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200/80 mb-3">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full {{ Auth::user()->isAdmin() ? 'bg-blue-600' : 'bg-teal-600' }} text-white font-bold flex items-center justify-center text-sm shadow-sm flex-shrink-0">
                                {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                            </div>
                            <div class="min-w-0 flex-1">
                                <p class="text-sm font-semibold text-slate-900 truncate">{{ Auth::user()->name }}</p>
                                <div class="flex items-center gap-1.5 mt-0.5">
                                    <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-bold tracking-wide uppercase {{ Auth::user()->isAdmin() ? 'bg-blue-100 text-blue-800' : 'bg-teal-100 text-teal-800' }}">
                                        {{ Auth::user()->role }}
                                    </span>
                                    <span class="text-[11px] text-slate-500 truncate">{{ Auth::user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center gap-1">
                        <a href="{{ route('profile.edit') }}" class="flex-1 flex items-center justify-center gap-1.5 px-3 py-2 rounded-lg text-xs font-medium text-slate-700 bg-white border border-slate-200 hover:bg-slate-50 transition-colors">
                            <svg class="w-3.5 h-3.5 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            Profile
                        </a>

                        <form method="POST" action="{{ route('logout') }}" class="flex-1">
                            @csrf
                            <button type="submit" class="w-full flex items-center justify-center gap-1.5 px-3 py-2 rounded-lg text-xs font-medium text-rose-700 bg-rose-50 border border-rose-200 hover:bg-rose-100 transition-colors">
                                <svg class="w-3.5 h-3.5 text-rose-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                Log Out
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Workspace Content -->
        <div class="lg:pl-72 flex-1 flex flex-col min-h-screen">
            <!-- Topbar -->
            <header class="bg-white border-b border-slate-200 h-16 flex items-center justify-between px-6 sm:px-8">
                <div class="flex items-center gap-3">
                    @isset($header)
                        {{ $header }}
                    @else
                        <h2 class="text-lg font-bold text-slate-800">Medical Case Workspace</h2>
                    @endisset
                </div>

                <div class="flex items-center gap-4">
                    <div class="hidden sm:flex items-center gap-2 text-xs text-slate-500 bg-slate-100 px-3 py-1.5 rounded-full border border-slate-200">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        <span>MySQL Connected</span>
                    </div>

                    <div class="flex items-center gap-2">
                        <span class="text-xs text-slate-500 hidden md:inline">Logged in as:</span>
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold {{ Auth::user()->isAdmin() ? 'bg-blue-100 text-blue-800' : 'bg-teal-100 text-teal-800' }}">
                            {{ Auth::user()->role }}
                        </span>
                    </div>
                </div>
            </header>

            <!-- Main Content Slot -->
            <main class="flex-1 p-6 sm:p-8 max-w-7xl w-full mx-auto">
                <x-alert-messages />
                {{ $slot }}
            </main>

            <!-- Footer -->
            <footer class="px-6 py-4 border-t border-slate-200 bg-white text-xs text-slate-500 flex flex-col sm:flex-row items-center justify-between gap-2">
                <div>
                    <span class="font-semibold text-slate-700">Jajal Medical</span> — Medical Case Management Platform
                </div>
                <div>
                    Software Developer Intern Practical Assignment &bull; October 2026
                </div>
            </footer>
        </div>
    </div>
</body>
</html>
