<x-app-layout>
    <x-slot name="title">Tambah Kategori Buku</x-slot>

    <div class="max-w-2xl">
        <div class="bg-white rounded-2xl shadow p-6 sm:p-8">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-11 h-11 rounded-xl bg-indigo-100 text-indigo-600 flex items-center justify-center text-xl">🏷️</div>
                <div>
                    <h3 class="font-semibold text-gray-800">Form Kategori Baru</h3>
                    <p class="text-xs text-gray-500">Isi nama kategori, keterangan opsional.</p>
                </div>
            </div>

            <form action="{{ route('kategori.store') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700">
                        Nama Kategori <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="nama_kategori" value="{{ old('nama_kategori') }}"
                           placeholder="Contoh: Fiksi, Non-Fiksi, Pelajaran"
                           class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('nama_kategori') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Keterangan</label>
                    <textarea name="keterangan" rows="3" placeholder="Deskripsi singkat kategori (opsional)"
                              class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('keterangan') }}</textarea>
                    @error('keterangan') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="flex gap-2 pt-2">
                    <button type="submit"
                            class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-lg shadow transition">Simpan</button>
                    <a href="{{ route('kategori.index') }}"
                       class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-5 py-2 rounded-lg transition">Batal</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>