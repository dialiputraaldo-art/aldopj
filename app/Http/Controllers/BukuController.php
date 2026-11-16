<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\KategoriBuku;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BukuController extends Controller
{
    public function index(): View
    {
        $buku = Buku::with('kategori')->orderBy('judul')->get();

        return view('buku.index', compact('buku'));
    }

    public function create(): View
    {
        $kategori = KategoriBuku::orderBy('nama_kategori')->get();

        return view('buku.create', compact('kategori'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'kategori_buku_id' => ['required', 'integer', 'exists:kategori_buku,id'],
            'judul'            => ['required', 'string', 'max:255'],
            'penulis'          => ['required', 'string', 'max:255'],
            'tahun_terbit'     => ['required', 'integer', 'min:1900', 'max:' . date('Y')],
        ], [
            'kategori_buku_id.required' => 'Kategori buku wajib dipilih.',
            'kategori_buku_id.exists'   => 'Kategori buku tidak valid.',
            'judul.required'            => 'Judul buku wajib diisi.',
            'penulis.required'          => 'Nama penulis wajib diisi.',
            'tahun_terbit.required'     => 'Tahun terbit wajib diisi.',
            'tahun_terbit.integer'      => 'Tahun terbit harus berupa angka.',
            'tahun_terbit.min'          => 'Tahun terbit minimal 1900.',
            'tahun_terbit.max'          => 'Tahun terbit tidak boleh melebihi tahun sekarang.',
        ]);

        Buku::create($data);

        return redirect()->route('buku.index')
                         ->with('success', 'Buku berhasil ditambahkan.');
    }

    public function edit(Buku $buku): View
    {
        $kategori = KategoriBuku::orderBy('nama_kategori')->get();

        return view('buku.edit', compact('buku', 'kategori'));
    }

    public function update(Request $request, Buku $buku): RedirectResponse
    {
        $data = $request->validate([
            'kategori_buku_id' => ['required', 'integer', 'exists:kategori_buku,id'],
            'judul'            => ['required', 'string', 'max:255'],
            'penulis'          => ['required', 'string', 'max:255'],
            'tahun_terbit'     => ['required', 'integer', 'min:1900', 'max:' . date('Y')],
        ], [
            'kategori_buku_id.required' => 'Kategori buku wajib dipilih.',
            'kategori_buku_id.exists'   => 'Kategori buku tidak valid.',
            'judul.required'            => 'Judul buku wajib diisi.',
            'penulis.required'          => 'Nama penulis wajib diisi.',
            'tahun_terbit.required'     => 'Tahun terbit wajib diisi.',
            'tahun_terbit.integer'      => 'Tahun terbit harus berupa angka.',
            'tahun_terbit.min'          => 'Tahun terbit minimal 1900.',
            'tahun_terbit.max'          => 'Tahun terbit tidak boleh melebihi tahun sekarang.',
        ]);

        $buku->update($data);

        return redirect()->route('buku.index')
                         ->with('success', 'Buku berhasil diperbarui.');
    }

    public function destroy(Buku $buku): RedirectResponse
    {
        if ($buku->peminjaman()->count() > 0) {
            return redirect()->route('buku.index')
                             ->with('error', 'Buku tidak bisa dihapus karena masih memiliki data peminjaman.');
        }

        $buku->delete();

        return redirect()->route('buku.index')
                         ->with('success', 'Buku berhasil dihapus.');
    }
}