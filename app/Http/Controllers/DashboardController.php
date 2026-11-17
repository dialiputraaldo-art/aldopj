<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\KategoriBuku;
use App\Models\Peminjaman;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        return view('dashboard', [
            'totalKategori'    => KategoriBuku::count(),
            'totalBuku'        => Buku::count(),
            'totalPeminjaman'  => Peminjaman::count(),
            'peminjamanTerbaru'=> Peminjaman::with(['buku', 'user'])
                                    ->latest('tanggal_peminjaman')
                                    ->take(5)
                                    ->get(),
        ]);
    }
}