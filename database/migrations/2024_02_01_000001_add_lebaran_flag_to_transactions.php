<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            // High-season / Lebaran flag — records which pricing tier was active
            $table->enum('pricing_mode', ['normal', 'lebaran'])->default('normal')->after('booth_type');
        });
    }

    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn('pricing_mode');
        });
    }
};