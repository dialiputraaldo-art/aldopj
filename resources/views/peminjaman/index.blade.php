<x-app-layout>
    <x-slot name="title">Daftar Peminjaman</x-slot>

    <div class="space-y-4">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3">
            <div>
                <p class="text-gray-600 text-sm">Riwayat peminjaman buku oleh warga sekolah.</p>
                <p class="text-xs text-gray-400 mt-1">Total: {{ $peminjaman->count() }} peminjaman</p>
            </div>
            <a href="{{ route('peminjaman.create') }}"
               class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg shadow transition">
                <span class="text-lg leading-none">＋</span> Catat Peminjaman
            </a>
        </div>

        <div class="bg-white rounded-2xl shadow overflow-hidden">
            @if ($peminjaman->isEmpty())
                <div class="p-10 text-center">
                    <div class="text-5xl mb-3">📝</div>
                    <p class="text-gray-500">Belum ada data peminjaman.</p>
                    <a href="{{ route('peminjaman.create') }}"
                       class="inline-block mt-4 text-indigo-600 hover:underline text-sm">+ Catat peminjaman pertama</a>
                </div>
            @else
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gradient-to-r from-indigo-50 to-indigo-100">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-indigo-700 uppercase">No</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-indigo-700 uppercase">Judul Buku</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-indigo-700 uppercase">Peminjam</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-indigo-700 uppercase">Tanggal</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-indigo-700 uppercase">Dicatat oleh</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($peminjaman as $i => $item)
                            <tr class="hover:bg-indigo-50/40 transition">
                                <td class="px-6 py-3 text-sm text-gray-600">{{ $i + 1 }}</td>
                                <td class="px-6 py-3 text-sm font-medium text-gray-800">{{ $item->buku->judul ?? '-' }}</td>
                                <td class="px-6 py-3 text-sm text-gray-600">{{ $item->nama_peminjam }}</td>
                                <td class="px-6 py-3 text-sm text-gray-600">{{ $item->tanggal_peminjaman->format('d-m-Y') }}</td>
                                <td class="px-6 py-3 text-sm">
                                    <span class="inline-block bg-indigo-100 text-indigo-700 text-xs font-semibold px-2.5 py-1 rounded-full">
                                        {{ $item->user->name ?? '-' }}
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