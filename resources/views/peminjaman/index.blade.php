<x-app-layout>
    <x-slot name="title">Daftar Peminjaman</x-slot>

    <div class="space-y-4">
        <div class="flex justify-between items-center">
            <p class="text-gray-600">Riwayat peminjaman buku oleh warga sekolah.</p>
            <a href="{{ route('peminjaman.create') }}"
               class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg shadow transition">
                + Catat Peminjaman
            </a>
        </div>

        <div class="bg-white rounded-2xl shadow overflow-hidden">
            @if ($peminjaman->isEmpty())
                <p class="p-6 text-gray-500">Belum ada data peminjaman.</p>
            @else
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Judul Buku</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Peminjam</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Dicatat oleh</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($peminjaman as $i => $item)
                            <tr class="hover:bg-gray-50">
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