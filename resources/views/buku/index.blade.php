<x-app-layout>
    <x-slot name="title">Daftar Buku</x-slot>

    <div class="space-y-4">
        <div class="flex justify-between items-center">
            <p class="text-gray-600">Kelola koleksi buku perpustakaan.</p>
            <a href="{{ route('buku.create') }}"
               class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg shadow transition">
                + Tambah Buku
            </a>
        </div>

        <div class="bg-white rounded-2xl shadow overflow-hidden">
            @if ($buku->isEmpty())
                <p class="p-6 text-gray-500">Belum ada buku.</p>
            @else
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Judul</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Penulis</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tahun</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kategori</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($buku as $i => $item)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-3 text-sm text-gray-600">{{ $i + 1 }}</td>
                                <td class="px-6 py-3 text-sm font-medium text-gray-800">{{ $item->judul }}</td>
                                <td class="px-6 py-3 text-sm text-gray-600">{{ $item->penulis }}</td>
                                <td class="px-6 py-3 text-sm text-gray-600">{{ $item->tahun_terbit }}</td>
                                <td class="px-6 py-3 text-sm">
                                    <span class="inline-block bg-emerald-100 text-emerald-700 text-xs font-semibold px-2.5 py-1 rounded-full">
                                        {{ $item->kategori->nama_kategori ?? '-' }}
                                    </span>
                                </td>
                                <td class="px-6 py-3 text-right space-x-2">
                                    <a href="{{ route('buku.edit', $item) }}"
                                       class="text-sm text-indigo-600 hover:underline">Ubah</a>
                                    <form action="{{ route('buku.destroy', $item) }}" method="POST"
                                          class="inline" onsubmit="return confirm('Hapus buku ini?')">
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