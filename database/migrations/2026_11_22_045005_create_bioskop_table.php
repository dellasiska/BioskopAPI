<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bioskop', function (Blueprint $table) {
            $table->id();
            $table->string('nama_bioskop', 100);
            $table->text('alamat');
            $table->string('kota', 50);
            $table->string('no_telepon', 20);
            $table->string('email', 100);
            $table->integer('jumlah_studio');
            $table->integer('kapasitas_total');
            $table->string('jam_operasional', 50);
            $table->string('status', 20);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bioskop');
    }
};
