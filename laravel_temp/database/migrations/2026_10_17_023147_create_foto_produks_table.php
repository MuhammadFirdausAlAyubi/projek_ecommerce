<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('foto_produk', function (Blueprint $table) {
            $table->bigIncrements('id_foto_produk');

            $table->unsignedBigInteger('id_produk');

            $table->string('gambar');

            $table->unsignedTinyInteger('urutan')->default(1);

            $table->timestamps();

            $table->foreign('id_produk')
                ->references('id_produk')
                ->on('produk')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('foto_produk');
    }
};