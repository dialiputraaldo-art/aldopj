<x-app-layout>
    <x-slot name="title">Tambah Buku</x-slot>

    <div class="max-w-2xl">
        <div class="bg-white rounded-2xl shadow p-6 sm:p-8">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-11 h-11 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center text-xl">📖</div>
                <div>
                    <h3 class="font-semibold text-gray-800">Form Buku Baru</h3>
                    <p class="text-xs text-gray-500">Isi data buku dan pilih kategori.</p>
                </div>
            </div>

            <form action="{{ route('buku.store') }}" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700">Judul Buku <span class="text-red-500">*</span></label>
                    <input type="text" name="judul" value="{{ old('judul') }}"
                           placeholder="Contoh: Laskar Pelangi"
                           class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('judul') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Penulis <span class="text-red-500">*</span></label>
                    <input type="text" name="penulis" value="{{ old('penulis') }}"
                           placeholder="Contoh: Andrea Hirata"
                           class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('penulis') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tahun Terbit <span class="text-red-500">*</span></label>
                        <input type="number" name="tahun_terbit" value="{{ old('tahun_terbit') }}"
                               min="1900" max="{{ date('Y') }}" placeholder="2020"
                               class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @error('tahun_terbit') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Kategori <span class="text-red-500">*</span></label>
                        <select name="kategori_buku_id"
                                class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">-- Pilih Kategori --</option>
                            @foreach ($kategori as $kat)
                                <option value="{{ $kat->id }}" @selected(old('kategori_buku_id') == $kat->id)>
                                    {{ $kat->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                        @error('kategori_buku_id') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="flex gap-2 pt-2">
                    <button type="submit"
                            class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-lg shadow transition">Simpan</button>
                    <a href="{{ route('buku.index') }}"
                       class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-5 py-2 rounded-lg transition">Batal</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>