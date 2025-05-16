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
        Schema::create('penggajians', function (Blueprint $table) {
            $table->id(); // ID auto-increment untuk penggajians

            // Kolom foreign key yang disesuaikan dengan pegawais.id (string)
            $table->string('pegawai_id', 10);
            $table->foreign('pegawai_id')
                  ->references('id')->on('pegawais')
                  ->onDelete('cascade');

            // Kolom bulan dan tahun penggajian
            $table->integer('bulan');
            $table->integer('tahun');

            // Detail gaji
            $table->decimal('gaji_pokok', 10, 2);
            $table->decimal('tunjangan', 10, 2)->default(0);
            $table->decimal('potongan', 10, 2)->default(0);
            $table->decimal('total_gaji', 10, 2);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penggajians');
    }
};
