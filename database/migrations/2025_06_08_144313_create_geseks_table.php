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
        Schema::create('geseks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_perhiasan')->constrained('perhiasans')->onDelete('cascade');
            $table->string('nama_bank');
            $table->string('nama');
            $table->integer('masuk');
            $table->integer('keluar');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('geseks');
    }
};
