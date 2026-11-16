<?php

namespace Database\Seeders;

use App\Models\Buku;
use App\Models\KategoriBuku;
use Illuminate\Database\Seeder;

class BukuSeeder extends Seeder
{
    public function run(): void
    {
        $fiksi     = KategoriBuku::where('nama_kategori', 'Fiksi')->first();
        $nonFiksi  = KategoriBuku::where('nama_kategori', 'Non-Fiksi')->first();
        $pelajaran = KategoriBuku::where('nama_kategori', 'Pelajaran')->first();

        $buku = [
            ['kategori_buku_id' => $fiksi->id,     'judul' => 'Laskar Pelangi',        'penulis' => 'Andrea Hirata',   'tahun_terbit' => 2005],
            ['kategori_buku_id' => $fiksi->id,     'judul' => 'Bumi Manusia',          'penulis' => 'Pramoedya A. Toer','tahun_terbit' => 1980],
            ['kategori_buku_id' => $nonFiksi->id,  'judul' => 'Sejarah Indonesia Modern','penulis' => 'M.C. Ricklefs',   'tahun_terbit' => 2008],
            ['kategori_buku_id' => $pelajaran->id, 'judul' => 'Matematika Kelas X',    'penulis' => 'Kemdikbud',       'tahun_terbit' => 2020],
            ['kategori_buku_id' => $pelajaran->id, 'judul' => 'Bahasa Indonesia Kelas X','penulis' => 'Kemdikbud',     'tahun_terbit' => 2021],
        ];

        foreach ($buku as $b) {
            Buku::updateOrCreate(
                ['judul' => $b['judul']],
                $b
            );
        }
    }
}