<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'SIMBA Rektorat') }} - Admin</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="font-sans antialiased bg-[#0f1115] text-gray-200">

    <div x-data="{ sidebarOpen: false }" class="flex h-screen overflow-hidden">

        <div :class="sidebarOpen ? 'block' : 'hidden'" @click="sidebarOpen = false"
            class="fixed z-20 inset-0 bg-black bg-opacity-70 backdrop-blur-sm transition-opacity lg:hidden"></div>

        <aside :class="sidebarOpen ? 'translate-x-0 ease-out' : '-translate-x-full ease-in'"
            class="fixed z-30 inset-y-0 left-0 w-64 transition duration-300 transform bg-[#090a0c] border-r border-gray-800 overflow-y-auto lg:translate-x-0 lg:static lg:inset-0 flex flex-col shadow-2xl">

            <div class="flex items-center justify-center mt-8 text-center">
                <div class="flex items-center">
                    <svg class="w-8 h-8 text-blue-500 drop-shadow-[0_0_8px_rgba(59,130,246,0.8)]" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                        </path>
                    </svg>
                    <span
                        class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-cyan-400 text-2xl font-extrabold ml-2 drop-shadow-[0_0_10px_rgba(56,189,248,0.3)]">SIMBA</span>
                </div>
            </div>
            <div class="text-blue-500/50 text-[10px] text-center mt-1 font-bold tracking-[0.1em] uppercase">Sistem Informasi Beasiswa</div>

            <nav class="mt-10 px-4 space-y-3 flex-1">
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center px-4 py-3 group {{ request()->routeIs('admin.dashboard') ? 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl shadow-[0_0_20px_rgba(37,99,235,0.4)]' : 'text-gray-400 hover:text-blue-300 hover:bg-gray-800/50 rounded-xl transition-all duration-300' }}">
                    <svg class="w-5 h-5 {{ request()->routeIs('admin.dashboard') ? 'text-white' : 'text-gray-500 group-hover:text-blue-400 transition-colors' }}"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                        </path>
                    </svg>
                    <span class="mx-3 font-medium">Beranda Eksekutif</span>
                </a>

                <a href="{{ route('master.periode') }}"
                    class="flex items-center px-4 py-3 group {{ request()->routeIs('master.periode') ? 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl shadow-[0_0_20px_rgba(37,99,235,0.4)]' : 'text-gray-400 hover:text-blue-300 hover:bg-gray-800/50 rounded-xl transition-all duration-300' }}">
                    <svg class="w-5 h-5 {{ request()->routeIs('master.periode') ? 'text-white' : 'text-gray-500 group-hover:text-blue-400 transition-colors' }}"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
                    </svg>
                    <span class="mx-3 font-medium">Master Periode</span>
                </a>

                <a href="{{ route('admin.pendaftar') }}"
                    class="flex items-center px-4 py-3 group {{ request()->routeIs('admin.pendaftar') ? 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl shadow-[0_0_20px_rgba(37,99,235,0.4)]' : 'text-gray-400 hover:text-blue-300 hover:bg-gray-800/50 rounded-xl transition-all duration-300' }}">
                    <svg class="w-5 h-5 {{ request()->routeIs('admin.pendaftar') ? 'text-white' : 'text-gray-500 group-hover:text-blue-400 transition-colors' }}"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4">
                        </path>
                    </svg>
                    <span class="mx-3 font-medium">Validasi Pendaftar</span>
                </a>

                <a href="{{ route('admin.hasil') }}"
                    class="flex items-center px-4 py-3 group {{ request()->routeIs('admin.hasil') ? 'bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl shadow-[0_0_20px_rgba(37,99,235,0.4)]' : 'text-gray-400 hover:text-blue-300 hover:bg-gray-800/50 rounded-xl transition-all duration-300' }}">
                    <svg class="w-5 h-5 {{ request()->routeIs('admin.hasil') ? 'text-white' : 'text-gray-500 group-hover:text-blue-400 transition-colors' }}"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                    <span class="mx-3 font-medium">Hasil Seleksi SAW</span>
                </a>
            </nav>

            <div class="p-4 bg-[#090a0c] border-t border-gray-800/60 mt-auto">
                <div class="flex items-center bg-gray-900/50 p-3 rounded-xl border border-gray-800">
                    <div
                        class="w-9 h-9 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 text-white flex items-center justify-center font-bold shadow-[0_0_10px_rgba(37,99,235,0.5)]">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                    <div class="ml-3 overflow-hidden">
                        <p class="text-sm font-semibold text-gray-200 truncate">{{ auth()->user()->name }}</p>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a href="{{ route('logout') }}"
                                onclick="event.preventDefault(); this.closest('form').submit();"
                                class="text-[11px] text-gray-500 hover:text-blue-400 transition-colors flex items-center gap-1 mt-0.5">
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                    </path>
                                </svg>
                                Sign Out
                            </a>
                        </form>
                    </div>
                </div>
            </div>
        </aside>

        <div class="flex-1 flex flex-col overflow-hidden relative">

            <div
                class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 rounded-full bg-blue-600/5 blur-[120px] pointer-events-none">
            </div>
            <div class="absolute bottom-0 left-0 w-72 h-72 rounded-full bg-cyan-600/5 blur-[100px] pointer-events-none">
            </div>

            <header class="bg-[#090a0c]/80 backdrop-blur-md border-b border-gray-800 shadow-sm lg:hidden relative z-10">
                <div class="flex items-center justify-between p-4">
                    <button @click="sidebarOpen = true"
                        class="text-gray-400 hover:text-blue-400 focus:outline-none transition-colors">
                        <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4 6H20M4 12H20M4 18H11" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                    </button>
                    <div
                        class="text-lg font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-cyan-400 drop-shadow-[0_0_8px_rgba(56,189,248,0.5)] tracking-wide">
                        SIMBA Admin
                    </div>
            </header>

            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-transparent relative z-10">
                <div class="container mx-auto px-6 py-8">
                   @isset($slot)
                        {{ $slot }}
                    @else
                        @yield('content')
                    @endisset
                </div>
            </main>

        </div>
    </div>

</body>

</html>
