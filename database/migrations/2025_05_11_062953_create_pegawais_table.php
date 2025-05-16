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
        Schema::create('pegawais', function (Blueprint $table) {
            $table->string('id', 10)->primary(); // id string 10 karakter
            $table->string('nama');
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->string('no_hp');
            $table->string('posisi');
            $table->enum('shift', ['Pagi', 'Sore']);
            $table->date('tanggal_masuk');
            $table->enum('status_karyawan', ['Tetap', 'Kontrak']);
            
            $table->unsignedBigInteger('userId')->nullable()->index();
            $table->foreign('userId')->references('id')->on('users')->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pegawais', function (Blueprint $table) {
            $table->dropForeign(['userId']);
        });
        Schema::dropIfExists('pegawais');
    }
};
