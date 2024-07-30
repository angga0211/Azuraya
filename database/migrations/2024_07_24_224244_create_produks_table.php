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
        Schema::create('produks', function (Blueprint $table) {
            $table->id();
            $table->string('image')->nullable()->default("default");
            $table->string('nama');
            $table->string('slug')->unique();
            $table->foreignId('kategori_id')->references('id')->on('produk_kategoris')->onDelete('cascade');
            $table->decimal('harga', 10, 0);
            $table->integer('stok');
            $table->integer('berat')->default(0);
            $table->integer('diskon')->default(0);
            $table->integer('dibeli')->default(0);
            $table->decimal('hargaTotal', 10, 0);
            $table->text('deskripsi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produks');
    }
};
