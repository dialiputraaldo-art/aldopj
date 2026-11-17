<x-app-layout>
    <x-slot name="title">Dashboard</x-slot>

    <div class="space-y-6">
        {{-- Sapaan --}}
        <div class="bg-gradient-to-r from-indigo-600 to-indigo-800 rounded-2xl p-6 text-white shadow-lg">
            <h2 class="text-2xl font-bold">Selamat datang, {{ Auth::user()->name }} 👋</h2>
            <p class="mt-1 text-indigo-100">Kelola koleksi dan peminjaman perpustakaan sekolah dari satu tempat.</p>
        </div>

        {{-- Statistik --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <div class="bg-white rounded-2xl shadow p-5 border-l-4 border-indigo-500 flex items-center gap-4">
                <div class="w-12 h-12 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center text-2xl">🏷️</div>
                <div>
                    <p class="text-sm text-gray-500">Total Kategori</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $totalKategori }}</p>
                </div>
            </div>
            <div class="bg-white rounded-2xl shadow p-5 border-l-4 border-emerald-500 flex items-center gap-4">
                <div class="w-12 h-12 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center text-2xl">📖</div>
                <div>
                    <p class="text-sm text-gray-500">Total Buku</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $totalBuku }}</p>
                </div>
            </div>
            <div class="bg-white rounded-2xl shadow p-5 border-l-4 border-amber-500 flex items-center gap-4">
                <div class="w-12 h-12 rounded-full bg-amber-100 text-amber-600 flex items-center justify-center text-2xl">📝</div>
                <div>
                    <p class="text-sm text-gray-500">Total Peminjaman</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $totalPeminjaman }}</p>
                </div>
            </div>
        </div>

        {{-- Peminjaman terbaru --}}
        <div class="bg-white rounded-2xl shadow overflow-hidden">
            <div class="px-6 py-4 border-b flex justify-between items-center">
                <h3 class="font-semibold text-gray-800">Peminjaman Terbaru</h3>
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
                                <td class="px-6 py-3 text-sm text-gray-800">{{ $p->buku->judul ?? '-' }}</td>
                                <td class="px-6 py-3 text-sm text-gray-600">{{ $p->nama_peminjam }}</td>
                                <td class="px-6 py-3 text-sm text-gray-600">{{ $p->tanggal_peminjaman->format('d-m-Y') }}</td>
                                <td class="px-6 py-3 text-sm text-gray-600">{{ $p->user->name ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</x-app-layout>