<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('varian_produk', function (Blueprint $table) {
            $table->bigIncrements('id_varian');

            $table->unsignedInteger('id_produk');

            $table->string('nama_varian', 100);
            $table->string('warna', 50)->nullable();
            $table->string('kapasitas', 50)->nullable();

            $table->decimal('harga', 15, 2)->nullable();

            $table->unsignedInteger('jumlah_stok')->default(0);
            $table->string('gambar')->nullable();

            $table->boolean('status_varian')->default(true);

            $table->timestamps();

            $table->foreign('id_produk')
                ->references('id_produk')
                ->on('produk')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('varian_produk');
    }
};