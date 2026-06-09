<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cashflows', function (Blueprint $table) {
            // Tag which booth this cash entry belongs to (for role-isolated export)
            $table->enum('booth_type', ['loket_masuk', 'kolam_renang', 'kelinci', 'admin'])
                  ->nullable()
                  ->after('user_id');
        });
    }

    public function down(): void
    {
        Schema::table('cashflows', function (Blueprint $table) {
            $table->dropColumn('booth_type');
        });
    }
};