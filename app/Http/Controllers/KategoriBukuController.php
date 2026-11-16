<?php

namespace App\Http\Controllers;

use App\Models\KategoriBuku;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class KategoriBukuController extends Controller
{
    public function index(): View
    {
        $kategori = KategoriBuku::withCount('buku')
                    ->orderBy('nama_kategori')
                    ->get();

        return view('kategori.index', compact('kategori'));
    }

    public function create(): View
    {
        return view('kategori.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'nama_kategori' => ['required', 'string', 'max:100'],
            'keterangan'    => ['nullable', 'string', 'max:255'],
        ], [
            'nama_kategori.required' => 'Nama kategori wajib diisi.',
            'nama_kategori.max'      => 'Nama kategori maksimal 100 karakter.',
            'keterangan.max'         => 'Keterangan maksimal 255 karakter.',
        ]);

        KategoriBuku::create($data);

        return redirect()->route('kategori.index')
                         ->with('success', 'Kategori buku berhasil ditambahkan.');
    }

    public function edit(KategoriBuku $kategori): View
    {
        return view('kategori.edit', compact('kategori'));
    }

    public function update(Request $request, KategoriBuku $kategori): RedirectResponse
    {
        $data = $request->validate([
            'nama_kategori' => ['required', 'string', 'max:100'],
            'keterangan'    => ['nullable', 'string', 'max:255'],
        ], [
            'nama_kategori.required' => 'Nama kategori wajib diisi.',
            'nama_kategori.max'      => 'Nama kategori maksimal 100 karakter.',
            'keterangan.max'         => 'Keterangan maksimal 255 karakter.',
        ]);

        $kategori->update($data);

        return redirect()->route('kategori.index')
                         ->with('success', 'Kategori buku berhasil diperbarui.');
    }

    public function destroy(KategoriBuku $kategori): RedirectResponse
    {
        if ($kategori->buku()->count() > 0) {
            return redirect()->route('kategori.index')
                             ->with('error', 'Kategori tidak bisa dihapus karena masih memiliki buku terkait.');
        }

        $kategori->delete();

        return redirect()->route('kategori.index')
                         ->with('success', 'Kategori buku berhasil dihapus.');
    }
}