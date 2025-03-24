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
        Schema::table('kategori_menus', function (Blueprint $table) {
            // Ubah id_kategori dari INT ke STRING (VARCHAR)
            $table->string('id_kategori', 10)->change();
            //
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kategori_menus', function (Blueprint $table) {
            // Jika ingin rollback, ubah kembali ke INTEGER
            $table->integer('id_kategori')->change();
        });
    }
};
