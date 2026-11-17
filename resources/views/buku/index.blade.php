<x-app-layout>
    <x-slot name="title">Daftar Buku</x-slot>

    <div class="space-y-4">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3">
            <div>
                <p class="text-gray-600 text-sm">Kelola koleksi buku perpustakaan.</p>
                <p class="text-xs text-gray-400 mt-1">Total: {{ $buku->count() }} buku</p>
            </div>
            <a href="{{ route('buku.create') }}"
               class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg shadow transition">
                <span class="text-lg leading-none">＋</span> Tambah Buku
            </a>
        </div>

        <div class="bg-white rounded-2xl shadow overflow-hidden">
            @if ($buku->isEmpty())
                <div class="p-10 text-center">
                    <div class="text-5xl mb-3">📖</div>
                    <p class="text-gray-500">Belum ada buku.</p>
                    <a href="{{ route('buku.create') }}"
                       class="inline-block mt-4 text-indigo-600 hover:underline text-sm">+ Tambah buku pertama</a>
                </div>
            @else
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gradient-to-r from-indigo-50 to-indigo-100">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-indigo-700 uppercase">No</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-indigo-700 uppercase">Judul</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-indigo-700 uppercase">Penulis</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-indigo-700 uppercase">Tahun</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-indigo-700 uppercase">Kategori</th>
                            <th class="px-6 py-3 text-right text-xs font-semibold text-indigo-700 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($buku as $i => $item)
                            <tr class="hover:bg-indigo-50/40 transition">
                                <td class="px-6 py-3 text-sm text-gray-600">{{ $i + 1 }}</td>
                                <td class="px-6 py-3 text-sm font-medium text-gray-800">{{ $item->judul }}</td>
                                <td class="px-6 py-3 text-sm text-gray-600">{{ $item->penulis }}</td>
                                <td class="px-6 py-3 text-sm text-gray-600">{{ $item->tahun_terbit }}</td>
                                <td class="px-6 py-3 text-sm">
                                    <span class="inline-block bg-emerald-100 text-emerald-700 text-xs font-semibold px-2.5 py-1 rounded-full">
                                        {{ $item->kategori->nama_kategori ?? '-' }}
                                    </span>
                                </td>
                                <td class="px-6 py-3 text-right space-x-2 whitespace-nowrap">
                                    <a href="{{ route('buku.edit', $item) }}"
                                       class="text-sm text-indigo-600 hover:text-indigo-800 font-medium hover:underline">Ubah</a>
                                    <form action="{{ route('buku.destroy', $item) }}" method="POST"
                                          class="inline" onsubmit="return confirm('Hapus buku ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-sm text-red-600 hover:text-red-800 font-medium hover:underline">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</x-app-layout>