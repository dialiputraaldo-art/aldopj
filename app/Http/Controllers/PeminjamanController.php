<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Peminjaman;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PeminjamanController extends Controller
{
    public function index(): View
    {
        $peminjaman = Peminjaman::with(['buku', 'user'])
                        ->latest('tanggal_peminjaman')
                        ->get();

        return view('peminjaman.index', compact('peminjaman'));
    }

    public function create(): View
    {
        $buku = Buku::with('kategori')->orderBy('judul')->get();

        return view('peminjaman.create', compact('buku'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'buku_id'            => ['required', 'integer', 'exists:buku,id'],
            'nama_peminjam'      => ['required', 'string', 'max:255'],
            'tanggal_peminjaman' => ['required', 'date'],
        ], [
            'buku_id.required'            => 'Buku wajib dipilih.',
            'buku_id.exists'              => 'Buku tidak valid.',
            'nama_peminjam.required'      => 'Nama peminjam wajib diisi.',
            'tanggal_peminjaman.required' => 'Tanggal peminjaman wajib diisi.',
            'tanggal_peminjaman.date'     => 'Tanggal peminjaman tidak valid.',
        ]);

        $data['user_id'] = $request->user()->id;   // WAJIB dari sesi login

        Peminjaman::create($data);

        return redirect()->route('peminjaman.index')
                         ->with('success', 'Peminjaman berhasil dicatat.');
    }
}