<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jadwal_film', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bioskop_id')->constrained('bioskop')->onDelete('cascade');
            $table->string('judul_film', 150);
            $table->string('genre', 50);
            $table->string('studio', 20);
            $table->date('tanggal_tayang');
            $table->time('jam_mulai');
            $table->decimal('harga_tiket', 10, 2);
            $table->string('status_tayang', 20);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jadwal_film');
    }
};