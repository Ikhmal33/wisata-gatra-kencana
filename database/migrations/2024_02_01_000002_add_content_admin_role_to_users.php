<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // MySQL: modify the enum to include 'content_admin' role for Tejo
        // Note: for PostgreSQL use a different approach.
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin','cashier','content_admin') NOT NULL DEFAULT 'cashier'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin','cashier') NOT NULL DEFAULT 'cashier'");
    }
};