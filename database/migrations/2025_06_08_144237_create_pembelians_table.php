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
        Schema::create('pembelians', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_bulan')->constrained('histories')->onDelete('cascade');
            $table->foreignId('id_perhiasan')->constrained('perhiasans')->onDelete('cascade');
            $table->foreignId('id_produk')->constrained('products')->onDelete('cascade');
            $table->string('nama_barang');
            $table->date('tanggal');
            $table->integer('kadar');
            $table->integer('berat');
            $table->integer('kode');
            $table->integer('pergram_beli');
            $table->integer('pergram_jual');
            $table->string('keterangan')->nullable();
            $table->string('sales');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembelians');
    }
};
