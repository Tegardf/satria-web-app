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
        Schema::create('restocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_perhiasan')->constrained('perhiasans')->onDelete('cascade');
            $table->foreignId('id_produk')->constrained('products')->onDelete('cascade');
            $table->string('model');
            $table->float('berat');
            $table->string('ukuran');
            $table->integer('kadar');
            $table->integer('jumlah');
            $table->boolean('status')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('restocks');
    }
};
