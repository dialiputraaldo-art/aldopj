<x-app-layout>
    <x-slot name="title">Kategori Buku</x-slot>

    <div class="space-y-4">
        <div class="flex justify-between items-center">
            <p class="text-gray-600">Kelola kategori koleksi perpustakaan.</p>
            <a href="{{ route('kategori.create') }}"
               class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg shadow transition">
                + Tambah Kategori
            </a>
        </div>

        <div class="bg-white rounded-2xl shadow overflow-hidden">
            @if ($kategori->isEmpty())
                <p class="p-6 text-gray-500">Belum ada kategori buku.</p>
            @else
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Kategori</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Keterangan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jumlah Buku</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($kategori as $i => $item)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-3 text-sm text-gray-600">{{ $i + 1 }}</td>
                                <td class="px-6 py-3 text-sm font-medium text-gray-800">{{ $item->nama_kategori }}</td>
                                <td class="px-6 py-3 text-sm text-gray-600">{{ $item->keterangan ?? '-' }}</td>
                                <td class="px-6 py-3 text-sm">
                                    <span class="inline-block bg-indigo-100 text-indigo-700 text-xs font-semibold px-2.5 py-1 rounded-full">
                                        {{ $item->buku_count }} buku
                                    </span>
                                </td>
                                <td class="px-6 py-3 text-right space-x-2">
                                    <a href="{{ route('kategori.edit', $item) }}"
                                       class="text-sm text-indigo-600 hover:underline">Ubah</a>
                                    <form action="{{ route('kategori.destroy', $item) }}" method="POST"
                                          class="inline" onsubmit="return confirm('Hapus kategori ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-sm text-red-600 hover:underline">Hapus</button>
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