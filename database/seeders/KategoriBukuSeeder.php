<?php

namespace Database\Seeders;

use App\Models\KategoriBuku;
use Illuminate\Database\Seeder;

class KategoriBukuSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['nama_kategori' => 'Fiksi',       'keterangan' => 'Novel, cerpen, roman'],
            ['nama_kategori' => 'Non-Fiksi',   'keterangan' => 'Biografi, sejarah, sains populer'],
            ['nama_kategori' => 'Pelajaran',   'keterangan' => 'Buku teks dan modul sekolah'],
        ];

        foreach ($data as $d) {
            KategoriBuku::updateOrCreate(
                ['nama_kategori' => $d['nama_kategori']],
                $d
            );
        }
    }
}