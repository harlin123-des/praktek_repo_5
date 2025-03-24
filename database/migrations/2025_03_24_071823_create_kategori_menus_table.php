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
        Schema::create('kategori_menus', function (Blueprint $table) {
            $table->id('id_kategori'); // ID sebagai auto-increment integer
            $table->string('nama_kategori'); // Nama kategori menu
            $table->text('keterangan')->nullable(); // Keterangan opsional
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kategori_menus');
    }
};
