<x-app-layout>
    <x-slot name="title">Catat Peminjaman</x-slot>

    <div class="max-w-2xl">
        <div class="bg-white rounded-2xl shadow p-6 sm:p-8">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-11 h-11 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center text-xl">📝</div>
                <div>
                    <h3 class="font-semibold text-gray-800">Form Peminjaman Baru</h3>
                    <p class="text-xs text-gray-500">Pilih buku, isi nama peminjam & tanggal.</p>
                </div>
            </div>

            <form action="{{ route('peminjaman.store') }}" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700">Buku <span class="text-red-500">*</span></label>
                    <select name="buku_id"
                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">-- Pilih Buku --</option>
                        @foreach ($buku as $b)
                            <option value="{{ $b->id }}" @selected(old('buku_id') == $b->id)>
                                {{ $b->judul }} — {{ $b->penulis }} ({{ $b->kategori->nama_kategori ?? '-' }})
                            </option>
                        @endforeach
                    </select>
                    @error('buku_id') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Nama Peminjam <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_peminjam" value="{{ old('nama_peminjam') }}"
                           placeholder="Nama siswa/guru peminjam"
                           class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('nama_peminjam') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Tanggal Peminjaman <span class="text-red-500">*</span></label>
                    <input type="date" name="tanggal_peminjaman"
                           value="{{ old('tanggal_peminjaman', date('Y-m-d')) }}"
                           class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('tanggal_peminjaman') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="bg-indigo-50 border border-indigo-100 rounded-lg p-3 text-xs text-indigo-700">
                    ℹ️ Pengguna pencatat otomatis diisi dari akun yang sedang login (<strong>{{ Auth::user()->name }}</strong>).
                </div>

                <div class="flex gap-2 pt-2">
                    <button type="submit"
                            class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-lg shadow transition">Simpan</button>
                    <a href="{{ route('peminjaman.index') }}"
                       class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-5 py-2 rounded-lg transition">Batal</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>