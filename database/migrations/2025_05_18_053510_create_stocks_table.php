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
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_perhiasan')->constrained('perhiasans')->onDelete('cascade');
            $table->foreignId('id_produk')->constrained('products')->onDelete('cascade');
            $table->string('kode');
            $table->string('nama');
            $table->date('tanggal');
            $table->integer('jumlah');
            $table->decimal('berat_kotor', 8, 3);
            $table->decimal('berat_bersih', 8, 3);
            $table->decimal('berat_kitir', 8, 3);
            $table->integer('pergram');
            $table->integer('real')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stocks');
    }
};
