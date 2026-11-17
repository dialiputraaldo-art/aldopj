<x-app-layout>
    <x-slot name="title">Kategori Buku</x-slot>

    <div class="space-y-4">

        {{-- Header halaman --}}
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3">
            <div>
                <p class="text-gray-600 text-sm">Kelola kategori koleksi perpustakaan.</p>
                <p class="text-xs text-gray-400 mt-1">Total: {{ $kategori->count() }} kategori</p>
            </div>
            <a href="{{ route('kategori.create') }}"
               class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg shadow transition">
                <span class="text-lg leading-none">＋</span> Tambah Kategori
            </a>
        </div>

        {{-- Card tabel --}}
        <div class="bg-white rounded-2xl shadow overflow-hidden">
            @if ($kategori->isEmpty())
                <div class="p-10 text-center">
                    <div class="text-5xl mb-3">🏷️</div>
                    <p class="text-gray-500">Belum ada kategori buku.</p>
                    <a href="{{ route('kategori.create') }}"
                       class="inline-block mt-4 text-indigo-600 hover:underline text-sm">+ Tambah kategori pertama</a>
                </div>
            @else
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gradient-to-r from-indigo-50 to-indigo-100">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-indigo-700 uppercase">No</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-indigo-700 uppercase">Nama Kategori</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-indigo-700 uppercase">Keterangan</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-indigo-700 uppercase">Jumlah Buku</th>
                            <th class="px-6 py-3 text-right text-xs font-semibold text-indigo-700 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($kategori as $i => $item)
                            <tr class="hover:bg-indigo-50/40 transition">
                                <td class="px-6 py-3 text-sm text-gray-600">{{ $i + 1 }}</td>
                                <td class="px-6 py-3 text-sm font-medium text-gray-800">{{ $item->nama_kategori }}</td>
                                <td class="px-6 py-3 text-sm text-gray-600">{{ $item->keterangan ?? '-' }}</td>
                                <td class="px-6 py-3 text-sm">
                                    <span class="inline-block bg-indigo-100 text-indigo-700 text-xs font-semibold px-2.5 py-1 rounded-full">
                                        {{ $item->buku_count }} buku
                                    </span>
                                </td>
                                <td class="px-6 py-3 text-right space-x-2 whitespace-nowrap">
                                    <a href="{{ route('kategori.edit', $item) }}"
                                       class="inline-block text-sm text-indigo-600 hover:text-indigo-800 font-medium hover:underline">Ubah</a>
                                    <form action="{{ route('kategori.destroy', $item) }}" method="POST"
                                          class="inline" onsubmit="return confirm('Hapus kategori ini?')">
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