<x-app-layout>
    <x-slot name="title">Dashboard</x-slot>

    <div class="space-y-6">

        {{-- Hero sapaan --}}
        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-indigo-600 via-indigo-700 to-indigo-900 p-6 sm:p-8 text-white shadow-xl">
            <div class="absolute -top-10 -right-10 w-40 h-40 bg-white/10 rounded-full"></div>
            <div class="absolute -bottom-12 -left-8 w-52 h-52 bg-white/5 rounded-full"></div>
            <div class="relative">
                <p class="text-indigo-200 text-sm">Selamat datang kembali,</p>
                <h2 class="text-2xl sm:text-3xl font-bold mt-1">{{ Auth::user()->name }} 👋</h2>
                <p class="mt-2 text-indigo-100 text-sm max-w-xl">
                    Kelola kategori, koleksi buku, dan pencatatan peminjaman perpustakaan sekolah dari satu tempat.
                </p>
                <div class="mt-5 flex flex-wrap gap-2">
                    <a href="{{ route('buku.create') }}"
                       class="bg-white text-indigo-700 hover:bg-indigo-50 font-semibold text-sm px-4 py-2 rounded-lg shadow transition">
                        + Tambah Buku
                    </a>
                    <a href="{{ route('peminjaman.create') }}"
                       class="bg-indigo-500/40 hover:bg-indigo-500/60 border border-white/30 text-white font-semibold text-sm px-4 py-2 rounded-lg transition">
                        + Catat Peminjaman
                    </a>
                </div>
            </div>
        </div>

        {{-- Statistik --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="bg-white rounded-2xl shadow p-5 flex items-center gap-4 border-l-4 border-indigo-500 hover:shadow-lg transition">
                <div class="w-12 h-12 rounded-xl bg-indigo-100 text-indigo-600 flex items-center justify-center text-2xl">🏷️</div>
                <div>
                    <p class="text-xs uppercase tracking-wide text-gray-500">Total Kategori</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $totalKategori }}</p>
                </div>
            </div>
            <div class="bg-white rounded-2xl shadow p-5 flex items-center gap-4 border-l-4 border-emerald-500 hover:shadow-lg transition">
                <div class="w-12 h-12 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center text-2xl">📖</div>
                <div>
                    <p class="text-xs uppercase tracking-wide text-gray-500">Total Buku</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $totalBuku }}</p>
                </div>
            </div>
            <div class="bg-white rounded-2xl shadow p-5 flex items-center gap-4 border-l-4 border-amber-500 hover:shadow-lg transition">
                <div class="w-12 h-12 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center text-2xl">📝</div>
                <div>
                    <p class="text-xs uppercase tracking-wide text-gray-500">Total Peminjaman</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $totalPeminjaman }}</p>
                </div>
            </div>
        </div>

        {{-- Peminjaman terbaru --}}
        <div class="bg-white rounded-2xl shadow overflow-hidden">
            <div class="px-6 py-4 border-b flex justify-between items-center bg-gray-50">
                <h3 class="font-semibold text-gray-800">📌 Peminjaman Terbaru</h3>
                <a href="{{ route('peminjaman.index') }}"
                   class="text-sm text-indigo-600 hover:underline">Lihat semua →</a>
            </div>
            @if ($peminjamanTerbaru->isEmpty())
                <p class="p-6 text-gray-500">Belum ada peminjaman.</p>
            @else
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Buku</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Peminjam</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Dicatat</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($peminjamanTerbaru as $p)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-3 text-sm font-medium text-gray-800">{{ $p->buku->judul ?? '-' }}</td>
                                <td class="px-6 py-3 text-sm text-gray-600">{{ $p->nama_peminjam }}</td>
                                <td class="px-6 py-3 text-sm text-gray-600">{{ $p->tanggal_peminjaman->format('d-m-Y') }}</td>
                                <td class="px-6 py-3 text-sm">
                                    <span class="inline-block bg-indigo-100 text-indigo-700 text-xs font-semibold px-2.5 py-1 rounded-full">
                                        {{ $p->user->name ?? '-' }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</x-app-layout>