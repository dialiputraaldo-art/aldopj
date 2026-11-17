<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Perpustakaan Sekolah') }} — {{ $title ?? 'Dashboard' }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            /* ===== HOVER POPUP MENU SIDEBAR ===== */
            .sidebar-item {
                position: relative;
                transition: all 0.25s cubic-bezier(0.22, 1, 0.36, 1);
            }
            .sidebar-item:hover {
                transform: translateX(4px) scale(1.03);
                background: rgba(99, 102, 241, 0.35);
                box-shadow: 0 6px 20px rgba(0, 0, 0, 0.25);
            }
            .sidebar-item .tooltip {
                position: absolute;
                left: calc(100% + 12px);
                top: 50%;
                transform: translateY(-50%) scale(0.9);
                opacity: 0;
                pointer-events: none;
                white-space: nowrap;
                background: rgba(255, 255, 255, 0.85);
                backdrop-filter: blur(12px) saturate(180%);
                -webkit-backdrop-filter: blur(12px) saturate(180%);
                color: #1e1b4b;
                font-size: 12px;
                font-weight: 600;
                padding: 6px 12px;
                border-radius: 10px;
                border: 1px solid rgba(255, 255, 255, 0.6);
                box-shadow: 0 8px 24px rgba(0, 0, 0, 0.25);
                transition: all 0.25s cubic-bezier(0.22, 1, 0.36, 1);
                z-index: 60;
            }
            .sidebar-item .tooltip::before {
                content: '';
                position: absolute;
                left: -5px;
                top: 50%;
                transform: translateY(-50%) rotate(45deg);
                width: 10px;
                height: 10px;
                background: rgba(255, 255, 255, 0.85);
                border-left: 1px solid rgba(255, 255, 255, 0.6);
                border-bottom: 1px solid rgba(255, 255, 255, 0.6);
            }
            .sidebar-item:hover .tooltip {
                opacity: 1;
                transform: translateY(-50%) scale(1);
            }
            .sidebar-item .icon-wrap {
                transition: transform 0.25s ease;
            }
            .sidebar-item:hover .icon-wrap {
                transform: scale(1.2) rotate(-6deg);
            }
        </style>
    </head>
    <body class="font-sans antialiased bg-gray-100">
        <div class="min-h-screen flex" x-data="{ sidebarOpen: false }">

            {{-- ===== SIDEBAR ===== --}}
            <aside class="fixed inset-y-0 left-0 z-40 w-64 bg-indigo-900 text-white transform transition-transform duration-200
                          lg:translate-x-0 lg:static lg:inset-0 flex flex-col"
                   :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">

                <div class="h-16 flex items-center px-6 border-b border-indigo-800 shrink-0">
                    <a href="{{ route('dashboard') }}" class="text-xl font-bold tracking-wide flex items-center gap-2">
                        📚 <span>Perpustakaan</span>
                    </a>
                </div>

                <nav class="flex-1 overflow-visible mt-4 px-3 space-y-1">
                    @php
                        $menus = [
                            ['route' => 'dashboard',        'pattern' => 'dashboard',     'label' => 'Dashboard',     'icon' => '🏠', 'desc' => 'Ringkasan statistik'],
                            ['route' => 'kategori.index',   'pattern' => 'kategori.*',    'label' => 'Kategori Buku', 'icon' => '🏷️', 'desc' => 'Kelola kategori'],
                            ['route' => 'buku.index',       'pattern' => 'buku.*',        'label' => 'Buku',          'icon' => '📖', 'desc' => 'Kelola koleksi buku'],
                            ['route' => 'peminjaman.index', 'pattern' => 'peminjaman.*',  'label' => 'Peminjaman',    'icon' => '📝', 'desc' => 'Catat & lihat peminjaman'],
                        ];
                    @endphp
                    @foreach ($menus as $m)
                        <a href="{{ route($m['route']) }}"
                           class="sidebar-item flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium
                                  {{ request()->routeIs($m['pattern'])
                                        ? 'bg-indigo-700 text-white shadow'
                                        : 'text-indigo-100' }}">
                            <span class="icon-wrap text-lg">{{ $m['icon'] }}</span>
                            <span>{{ $m['label'] }}</span>

                            {{-- Tooltip popup saat hover --}}
                            <span class="tooltip">
                                {{ $m['label'] }} — {{ $m['desc'] }}
                            </span>
                        </a>
                    @endforeach
                </nav>

                <div class="shrink-0 p-4 border-t border-indigo-800">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-full bg-indigo-600 flex items-center justify-center font-bold">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium truncate">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-indigo-300 truncate">{{ Auth::user()->email }}</p>
                        </div>
                    </div>
                </div>
            </aside>

            {{-- Overlay mobile --}}
            <div x-show="sidebarOpen" @click="sidebarOpen = false"
                 class="fixed inset-0 bg-black/40 z-30 lg:hidden" style="display:none;"></div>

            {{-- ===== KONTEN UTAMA ===== --}}
            <div class="flex-1 flex flex-col min-w-0">

                <header class="h-16 bg-white shadow-sm flex items-center justify-between px-4 lg:px-8 sticky top-0 z-20">
                    <div class="flex items-center gap-3">
                        <button @click="sidebarOpen = !sidebarOpen"
                                class="lg:hidden p-2 rounded-md text-gray-600 hover:bg-gray-100">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M4 6h16M4 12h16M4 18h16"/>
                            </svg>
                        </button>
                        <h1 class="text-lg font-semibold text-gray-800">
                            {{ $title ?? 'Dashboard' }}
                        </h1>
                    </div>

                    <div class="flex items-center gap-3">
                        <span class="hidden sm:block text-sm text-gray-500">{{ Auth::user()->name }}</span>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                    class="text-sm font-medium bg-red-600 hover:bg-red-700 text-white px-3 py-1.5 rounded-lg transition">
                                Logout
                            </button>
                        </form>
                    </div>
                </header>

                {{-- Flash message --}}
                <div class="px-4 lg:px-8 mt-4 space-y-2">
                    @if (session('success'))
                        <div class="bg-green-50 border-l-4 border-green-500 text-green-700 px-4 py-3 rounded shadow-sm">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="bg-red-50 border-l-4 border-red-500 text-red-700 px-4 py-3 rounded shadow-sm">
                            {{ session('error') }}
                        </div>
                    @endif
                </div>

                <main class="p-4 lg:p-8 flex-1">
                    {{ $slot }}
                </main>
            </div>
        </div>
    </body>
</html>