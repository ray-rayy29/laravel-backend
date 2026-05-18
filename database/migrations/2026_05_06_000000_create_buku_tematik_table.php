<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('buku_tematik', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_rak', 20);
            $table->string('judul');
            $table->string('penerbit', 100);
            $table->string('kelas', 10);
            $table->enum('semester', ['1', '2']);
            $table->enum('kurikulum', ['kurikulum_merdeka', 'kurikulum_2013']);
            $table->unsignedInteger('stok')->default(0);
            $table->string('gambar')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('buku_tematik');
    }
};
