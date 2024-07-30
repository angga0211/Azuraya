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
        Schema::create('pesanans', function (Blueprint $table) {
            $table->id();
            $table->string('invoice')->unique();
            $table->string('nama_pemesan');
            $table->string('telepon');
            $table->text('catatan');
            $table->text('alamat_pengiriman');
            $table->foreignId('user_id');
            $table->decimal('total', 10, 0);
            $table->decimal('ongkir', 10, 0);
            $table->decimal('subtotal', 10, 0);
            $table->string('layanan');
            $table->string('nomor_resi')->nullable();
            $table->string('snap_token')->nullable();
            $table->enum('bayar', ['Belum dibayar','Sudah dibayar'])->default("Belum dibayar");
            $table->enum('status', ['Pesanan Baru','Siap Dikirim', 'Dalam Pengiriman', 'Pesanan Selesai', 'Pesanan Dibatalkan'])->default("Pesanan Baru");
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanans');
    }
};
