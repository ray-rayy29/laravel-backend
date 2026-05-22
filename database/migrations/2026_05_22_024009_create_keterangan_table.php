<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('keterangan', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_rak', 20);
            $table->string('judul', 255);
            $table->string('penerbit', 100);
            $table->string('kelas', 10);
            $table->enum('semester', ['1', '2']);
            $table->enum('kurikulum', ['kurikulum_merdeka', 'kurikulum_2013']);
            $table->integer('stok')->default(0);
            $table->string('gambar')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('keterangan');
    }
};
