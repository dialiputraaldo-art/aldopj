<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('buku', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kategori_buku_id')
                  ->constrained('kategori_buku')
                  ->restrictOnDelete();          // tolak hapus jika masih dipakai
            $table->string('judul');
            $table->string('penulis');
            $table->unsignedSmallInteger('tahun_terbit');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('buku');
    }
};