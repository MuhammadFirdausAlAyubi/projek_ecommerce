<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('detail_keranjang', function (Blueprint $table) {
            $table->unsignedBigInteger('id_varian')
                ->nullable()
                ->after('id_produk');

            $table->foreign('id_varian')
                ->references('id_varian')
                ->on('varian_produk')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('detail_keranjang', function (Blueprint $table) {
            $table->dropForeign(['id_varian']);
            $table->dropColumn('id_varian');
        });
    }
};