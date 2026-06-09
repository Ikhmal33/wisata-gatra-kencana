<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_number')->unique();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('booth_type', ['loket_masuk', 'kolam_renang', 'kelinci']);
            $table->unsignedInteger('adult_qty')->default(0);
            $table->unsignedInteger('child_qty')->default(0);
            $table->unsignedInteger('terusan_qty')->default(0);
            $table->unsignedBigInteger('total_price');
            $table->enum('payment_method', ['cash', 'qris']);
            $table->unsignedBigInteger('cash_received')->default(0);
            $table->bigInteger('cash_change')->default(0);
            $table->date('transaction_date');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
