<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('peminjaman', function (Blueprint $table) {
            $table->dateTime('batas_pengembalian')->nullable()->change();
            $table->string('status', 32)->default('dipinjam')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (DB::table('peminjaman')->whereNull('batas_pengembalian')->exists()) {
            throw new RuntimeException('Cannot remove optional borrowing deadlines while a borrowing has no deadline.');
        }

        Schema::table('peminjaman', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropColumn('status');
            $table->dateTime('batas_pengembalian')->nullable(false)->change();
        });
    }
};
