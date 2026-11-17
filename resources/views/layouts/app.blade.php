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
            :root { --sidebar-width: 16rem; }
            #sidebar { width: var(--sidebar-width); transition: width 0.05s linear; }
            #sidebar.no-transition { transition: none; }

            #sidebar-resizer {
                position: absolute; top: 0; right: -3px; width: 6px; height: 100%;
                cursor: col-resize; background: transparent; z-index: 50; transition: background 0.2s;
            }
            #sidebar-resizer:hover, #sidebar-resizer.dragging { background: rgba(99, 102, 241, 0.6); }
            #sidebar-resizer::after {
                content: ''; position: absolute; left: 2px; top: 0; width: 2px; height: 100%;
                background: rgba(255, 255, 255, 0.15);
            }
            #sidebar-resizer:hover::after, #sidebar-resizer.dragging::after { background: rgba(255, 255, 255, 0.6); }

            .sidebar-item { position: relative; transition: all 0.25s cubic-bezier(0.22, 1, 0.36, 1); }
            .sidebar-item:hover {
                transform: translateX(4px) scale(1.03);
                background: rgba(99, 102, 241, 0.35);
                box-shadow: 0 6px 20px rgba(0, 0, 0, 0.25);
            }
            .sidebar-item .tooltip {
                position: absolute; left: calc(100% + 12px); top: 50%;
                transform: translateY(-50%) scale(0.9); opacity: 0; pointer-events: none;
                white-space: nowrap; background: rgba(255, 255, 255, 0.85);
                backdrop-filter: blur(12px) saturate(180%);
                -webkit-backdrop-filter: blur(12px) saturate(180%);
                color: #1e1b4b; font-size: 12px; font-weight: 600; padding: 6px 12px;
                border-radius: 10px; border: 1px solid rgba(255, 255, 255, 0.6);
                box-shadow: 0 8px 24px rgba(0, 0, 0, 0.25);
                transition: all 0.25s cubic-bezier(0.22, 1, 0.36, 1); z-index: 60;
            }
            .sidebar-item .tooltip::before {
                content: ''; position: absolute; left: -5px; top: 50%;
                transform: translateY(-50%) rotate(45deg); width: 10px; height: 10px;
                background: rgba(255, 255, 255, 0.85);
                border-left: 1px solid rgba(255, 255, 255, 0.6);
                border-bottom: 1px solid rgba(255, 255, 255, 0.6);
            }
            .sidebar-item:hover .tooltip { opacity: 1; transform: translateY(-50%) scale(1); }
            .sidebar-item .icon-wrap { transition: transform 0.25s ease; }
            .sidebar-item:hover .icon-wrap { transform: scale(1.2) rotate(-6deg); }

            #sidebar.narrow .tooltip, #sidebar.narrow .menu-label { display: none; }
            #sidebar.narrow .sidebar-item { justify-content: center; }
            body.resizing { cursor: col-resize !important; user-select: none; }

            /* ===== LIQUID GLASS POPUP ===== */
            .glass-popup {
                background: rgba(255, 255, 255, 0.55);
                backdrop-filter: blur(16px) saturate(180%);
                -webkit-backdrop-filter: blur(16px) saturate(180%);
                border: 1px solid rgba(255, 255, 255, 0.6);
                box-shadow: 0 8px 32px rgba(31, 38, 135, 0.25);
            }
            .glass-popup-error {
                background: rgba(254, 226, 226, 0.55);
                backdrop-filter: blur(16px) saturate(180%);
                -webkit-backdrop-filter: blur(16px) saturate(180%);
                border: 1px solid rgba(252, 165, 165, 0.6);
                box-shadow: 0 8px 32px rgba(185, 28, 28, 0.25);
            }
            @keyframes slideInRight {
                from { opacity: 0; transform: translateX(40px) scale(0.96); }
                to   { opacity: 1; transform: translateX(0) scale(1); }
            }
            @keyframes fadeOut {
                from { opacity: 1; transform: translateX(0) scale(1); }
                to   { opacity: 0; transform: translateX(40px) scale(0.96); }
            }
            .popup-enter { animation: slideInRight 0.35s cubic-bezier(0.22, 1, 0.36, 1) forwards; }
            .popup-leave { animation: fadeOut 0.35s ease-in forwards; }

            /* ===== MODAL LOGOUT ===== */
            @keyframes modalIn {
                from { opacity: 0; transform: scale(0.92) translateY(10px); }
                to   { opacity: 1; transform: scale(1) translateY(0); }
            }
            .modal-enter { animation: modalIn 0.25s cubic-bezier(0.22, 1, 0.36, 1) forwards; }
        </style>
    </head>
    <body class="font-sans antialiased bg-gray-100">
        <div class="min-h-screen flex" x-data="{ sidebarOpen: false }">

            {{-- ===== SIDEBAR ===== --}}
            <aside id="sidebar"
                   class="fixed inset-y-0 left-0 z-40 bg-indigo-900 text-white transform transition-transform duration-200
                          lg:translate-x-0 lg:static lg:inset-0 flex flex-col relative"
                   :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">

                <div class="h-16 flex items-center px-6 border-b border-indigo-800 shrink-0 overflow-hidden">
                    <a href="{{ route('dashboard') }}" class="text-xl font-bold tracking-wide flex items-center gap-2 whitespace-nowrap">
                        📚 <span class="menu-label">Perpustakaan</span>
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
                            <span class="menu-label">{{ $m['label'] }}</span>
                            <span class="tooltip">{{ $m['label'] }} — {{ $m['desc'] }}</span>
                        </a>
                    @endforeach
                </nav>

                <div class="shrink-0 p-4 border-t border-indigo-800 overflow-hidden">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-full bg-indigo-600 flex items-center justify-center font-bold shrink-0">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        <div class="flex-1 min-w-0 menu-label">
                            <p class="text-sm font-medium truncate">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-indigo-300 truncate">{{ Auth::user()->email }}</p>
                        </div>
                    </div>
                </div>

                <div id="sidebar-resizer" title="Geser untuk mengubah lebar sidebar"></div>
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
                        {{-- Tombol logout → buka modal, bukan submit langsung --}}
                        <button type="button" onclick="openLogoutModal()"
                                class="text-sm font-medium bg-red-600 hover:bg-red-700 text-white px-3 py-1.5 rounded-lg transition">
                            Logout
                        </button>
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

        {{-- ===== POPUP LIQUID GLASS ===== --}}
        <div id="glass-popup-container"
             class="fixed top-20 right-4 sm:right-6 z-[60] flex flex-col gap-3 w-[calc(100%-2rem)] sm:w-96 pointer-events-none">

            @if (session('success'))
                <div class="glass-popup popup-enter pointer-events-auto rounded-2xl px-5 py-4 flex items-start gap-3">
                    <div class="shrink-0 w-9 h-9 rounded-full bg-green-500 text-white flex items-center justify-center font-bold">✓</div>
                    <div class="flex-1">
                        <p class="text-sm font-semibold text-green-900">Berhasil</p>
                        <p class="text-sm text-gray-800 leading-snug">{{ session('success') }}</p>
                    </div>
                    <button onclick="closePopup(this)" class="shrink-0 text-gray-500 hover:text-gray-800 text-lg leading-none">×</button>
                </div>
            @endif

            @if (session('error'))
                <div class="glass-popup-error popup-enter pointer-events-auto rounded-2xl px-5 py-4 flex items-start gap-3">
                    <div class="shrink-0 w-9 h-9 rounded-full bg-red-500 text-white flex items-center justify-center font-bold">!</div>
                    <div class="flex-1">
                        <p class="text-sm font-semibold text-red-900">Gagal</p>
                        <p class="text-sm text-gray-800 leading-snug">{{ session('error') }}</p>
                    </div>
                    <button onclick="closePopup(this)" class="shrink-0 text-gray-500 hover:text-gray-800 text-lg leading-none">×</button>
                </div>
            @endif

            @if ($errors->any())
                <div class="glass-popup-error popup-enter pointer-events-auto rounded-2xl px-5 py-4 flex items-start gap-3">
                    <div class="shrink-0 w-9 h-9 rounded-full bg-red-500 text-white flex items-center justify-center font-bold">!</div>
                    <div class="flex-1">
                        <p class="text-sm font-semibold text-red-900">Validasi gagal</p>
                        <ul class="text-sm text-gray-800 list-disc list-inside leading-snug">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <button onclick="closePopup(this)" class="shrink-0 text-gray-500 hover:text-gray-800 text-lg leading-none">×</button>
                </div>
            @endif
        </div>

        {{-- ===== MODAL KONFIRMASI LOGOUT ===== --}}
        <div id="logout-modal" class="fixed inset-0 z-[70] hidden items-center justify-center p-4">
            {{-- Backdrop --}}
            <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" onclick="closeLogoutModal()"></div>

            {{-- Card --}}
            <div class="modal-enter relative glass-popup rounded-2xl w-full max-w-sm p-6 text-center">
                <div class="mx-auto w-14 h-14 rounded-full bg-red-100 text-red-600 flex items-center justify-center text-2xl mb-4">
                    ⏻
                </div>
                <h3 class="text-lg font-bold text-gray-900">Konfirmasi Logout</h3>
                <p class="text-sm text-gray-700 mt-1">Apakah Anda yakin ingin keluar dari aplikasi?</p>

                <div class="mt-6 flex gap-3">
                    <button type="button" onclick="closeLogoutModal()"
                            class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium py-2.5 rounded-lg transition">
                        Batal
                    </button>
                    <form method="POST" action="{{ route('logout') }}" class="flex-1">
                        @csrf
                        <button type="submit"
                                class="w-full bg-red-600 hover:bg-red-700 text-white font-medium py-2.5 rounded-lg shadow transition">
                            Ya, Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- ===== SCRIPT ===== --}}
        <script>
            // ---------- Popup liquid glass ----------
            function closePopup(btn) {
                const popup = btn.closest('div[class*="popup-enter"]') || btn.parentElement;
                popup.classList.remove('popup-enter');
                popup.classList.add('popup-leave');
                setTimeout(() => popup.remove(), 350);
            }
            document.addEventListener('DOMContentLoaded', () => {
                document.querySelectorAll('.popup-enter').forEach((el, i) => {
                    setTimeout(() => {
                        if (el && el.parentElement) {
                            el.classList.remove('popup-enter');
                            el.classList.add('popup-leave');
                            setTimeout(() => el.remove(), 350);
                        }
                    }, 4000 + i * 200);
                });
            });

            // ---------- Modal logout ----------
            function openLogoutModal() {
                const m = document.getElementById('logout-modal');
                m.classList.remove('hidden');
                m.classList.add('flex');
            }
            function closeLogoutModal() {
                const m = document.getElementById('logout-modal');
                m.classList.add('hidden');
                m.classList.remove('flex');
            }
            // Tutup modal dengan tombol Esc
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') closeLogoutModal();
            });

            // ---------- Resize sidebar ----------
            (function () {
                const sidebar = document.getElementById('sidebar');
                const resizer = document.getElementById('sidebar-resizer');
                const MIN_W = 80, MAX_W = 400, NARROW = 140;
                const saved = localStorage.getItem('sidebarWidth');
                if (saved) setWidth(parseInt(saved, 10), false);

                let isDragging = false;
                resizer.addEventListener('mousedown', (e) => {
                    isDragging = true;
                    resizer.classList.add('dragging');
                    document.body.classList.add('resizing');
                    sidebar.classList.add('no-transition');
                    e.preventDefault();
                });
                document.addEventListener('mousemove', (e) => {
                    if (!isDragging) return;
                    setWidth(e.clientX, false);
                });
                document.addEventListener('mouseup', () => {
                    if (!isDragging) return;
                    isDragging = false;
                    resizer.classList.remove('dragging');
                    document.body.classList.remove('resizing');
                    sidebar.classList.remove('no-transition');
                    const current = parseInt(getComputedStyle(sidebar).width, 10);
                    localStorage.setItem('sidebarWidth', current);
                });
                function setWidth(px, animate = true) {
                    px = Math.max(MIN_W, Math.min(MAX_W, px));
                    sidebar.style.width = px + 'px';
                    document.documentElement.style.setProperty('--sidebar-width', px + 'px');
                    if (px < NARROW) sidebar.classList.add('narrow');
                    else sidebar.classList.remove('narrow');
                }
                resizer.addEventListener('dblclick', () => {
                    setWidth(256);
                    localStorage.setItem('sidebarWidth', 256);
                });
            })();
        </script>
    </body>
</html>