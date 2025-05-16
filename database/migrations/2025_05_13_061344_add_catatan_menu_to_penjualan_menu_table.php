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
        Schema::table('penjualan_menu', function (Blueprint $table) {
            $table->text('catatan_menu')->nullable()->after('jml');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('penjualan_menu', function (Blueprint $table) {
            $table->dropColumn('catatan_menu');
        });
    }
};
