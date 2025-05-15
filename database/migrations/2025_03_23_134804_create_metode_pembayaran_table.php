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
        Schema::create('metode_pembayaran', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_pembayaran')->nullable(); // Tidak ada foreign key
            $table->string('nama_metode'); // Misalnya "Tunai" atau "QRIS"
            $table->enum('metode', ['cash', 'qris']); // Jenis metode pembayaran
            $table->boolean('status')->default(true); // Status aktif/tidak
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('metode_pembayaran');
    }
};
