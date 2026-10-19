<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ulasan_produk', function (Blueprint $table) {
            $table->bigIncrements('id_ulasan');

            $table->unsignedInteger('id_produk');
            $table->unsignedInteger('id_user');

            $table->unsignedTinyInteger('rating');
            $table->text('komentar')->nullable();

            $table->timestamps();

            $table->foreign('id_produk')
                ->references('id_produk')
                ->on('produk')
                ->cascadeOnDelete();

            $table->foreign('id_user')
                ->references('id_user')
                ->on('user')
                ->cascadeOnDelete();

            $table->unique(
                ['id_produk', 'id_user'],
                'ulasan_produk_user_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ulasan_produk');
    }
};
