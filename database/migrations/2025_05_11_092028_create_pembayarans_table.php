<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('pembayaran', 'order_id')) {
            Schema::table('pembayaran', function (Blueprint $table) {
                $table->string('order_id')->nullable();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('pembayaran', 'order_id')) {
            Schema::table('pembayaran', function (Blueprint $table) {
                $table->dropColumn('order_id');
            });
        }
    }
};
