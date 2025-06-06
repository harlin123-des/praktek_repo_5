<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('presensis', function (Blueprint $table) {

    $table->id();
    $table->foreignId('pegawai_id')->constrained()->onDelete('cascade');
    $table->date('tanggal');
    $table->time('jam_masuk')->nullable();
    $table->time('jam_keluar')->nullable();
    $table->string('status')->nullable(); // Hadir, Izin, dll
    $table->string('keterangan')->nullable();
    $table->timestamps();
});


            $table->id();
            $table->date('tanggal');
            $table->time('jam_masuk')->nullable();
            $table->time('jam_keluar')->nullable();
            $table->enum('status', ['Hadir', 'Tidak Hadir'])->nullable();
            $table->string('keterangan')->nullable();
            $table->string('pegawai_id');
            $table->foreign('pegawai_id')->references('id')->on('pegawais')->onDelete('cascade');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('presensis', function (Blueprint $table) {
            $table->dropForeign(['pegawai_id']);
        });
        Schema::dropIfExists('presensis');
    }
};
