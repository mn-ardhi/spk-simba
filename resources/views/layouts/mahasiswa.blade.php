<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Portal Beasiswa') }} - Mahasiswa</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-slate-50 text-gray-800"> <div class="fixed inset-0 z-[-1] bg-[radial-gradient(#e5e7eb_1px,transparent_1px)] [background-size:16px_16px] opacity-50"></div>

    <div class="min-h-screen flex flex-col" x-data="{ mobileMenuOpen: false }">
        
        <nav class="sticky top-0 z-50 bg-white/70 backdrop-blur-lg border-b border-gray-200/50 shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    
                    <div class="flex">
                        <div class="shrink-0 flex items-center">
                            <svg class="w-8 h-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"></path></svg>
                            <span class="ml-2 font-bold text-xl text-gray-900 tracking-tight">Portal <span class="text-blue-600">Beasiswa</span></span>
                        </div>
                        
                        <div class="hidden sm:-my-px sm:ml-8 sm:flex sm:space-x-8">
                            <a href="{{ route('mahasiswa.dashboard') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('mahasiswa.dashboard') ? 'border-blue-500 text-gray-900 font-semibold' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} text-sm transition duration-150 ease-in-out">
                                Beranda Utama
                            </a>
                            </div>
                    </div>

                    <div class="hidden sm:flex sm:items-center sm:ml-6">
                        <div class="flex items-center space-x-3 bg-white/50 border border-gray-200 px-4 py-1.5 rounded-full shadow-sm">
                            <span class="text-sm font-medium text-gray-700">{{ auth()->user()->name }}</span>
                            <div class="h-6 w-px bg-gray-300"></div>
                            <form method="POST" action="{{ route('logout') }}" class="m-0 p-0">
                                @csrf
                                <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="text-sm text-red-500 hover:text-red-700 font-medium transition">
                                    Keluar
                                </a>
                            </form>
                        </div>
                    </div>

                    <div class="-mr-2 flex items-center sm:hidden">
                        <button @click="mobileMenuOpen = !mobileMenuOpen" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path :class="{'hidden': mobileMenuOpen, 'inline-flex': !mobileMenuOpen }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                <path :class="{'hidden': !mobileMenuOpen, 'inline-flex': mobileMenuOpen }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <div :class="{'block': mobileMenuOpen, 'hidden': !mobileMenuOpen}" class="hidden sm:hidden bg-white border-b border-gray-200 shadow-lg absolute w-full">
                <div class="pt-2 pb-3 space-y-1">
                    <a href="{{ route('mahasiswa.dashboard') }}" class="block pl-3 pr-4 py-2 border-l-4 {{ request()->routeIs('mahasiswa.dashboard') ? 'border-blue-500 text-blue-700 bg-blue-50' : 'border-transparent text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300' }} text-base font-medium transition duration-150 ease-in-out">
                        Beranda Utama
                    </a>
                </div>
                <div class="pt-4 pb-1 border-t border-gray-200">
                    <div class="flex items-center px-4">
                        <div class="font-medium text-base text-gray-800">{{ auth()->user()->name }}</div>
                    </div>
                    <div class="mt-3 space-y-1">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="block pl-3 pr-4 py-2 border-l-4 border-transparent text-red-600 hover:text-red-800 hover:bg-red-50 hover:border-red-300 text-base font-medium transition duration-150 ease-in-out">
                                Keluar
                            </a>
                        </form>
                    </div>
                </div>
            </div>
        </nav>

        <main class="flex-1 w-full relative z-10 pt-8 pb-12">
            {{ $slot }}
        </main>

        <footer class="bg-white border-t border-gray-200 mt-auto py-6">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-sm text-gray-500">
                &copy; {{ date('Y') }} Sistem Informasi Beasiswa (SIMBA): Portal Beasiswa.
            </div>
        </footer>

    </div>
</body>
</html>