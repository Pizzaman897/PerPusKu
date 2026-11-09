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
        Schema::create('peminjaman', function (Blueprint $table) {
            $table->id();
            $table->foreignId('murid_id')
                ->constrained('murids')
                ->restrictOnDelete();
            $table->foreignId('buku_id')
                ->constrained('buku')
                ->restrictOnDelete();
            $table->dateTime('dipinjam_pada');
            $table->dateTime('batas_pengembalian');
            $table->dateTime('dikembalikan_pada')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjaman');
    }
};
