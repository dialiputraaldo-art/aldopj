<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('peminjaman', function (Blueprint $table) {
            $table->id();
            $table->foreignId('buku_id')
                  ->constrained('buku')
                  ->restrictOnDelete();
            $table->foreignId('user_id')                 // pengguna pencatat
                  ->constrained('users')
                  ->restrictOnDelete();
            $table->string('nama_peminjam');
            $table->date('tanggal_peminjaman');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peminjaman');
    }
};