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
    Schema::create('transactions', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // Customer
        $table->foreignId('service_id')->constrained()->cascadeOnDelete(); // Layanan yang dipilih
        $table->integer('weight_or_qty')->default(1); // Berat atau Jumlah
        $table->decimal('total_price', 10, 2); // Harga total setelah diskon (jika ada)
        $table->enum('status', ['pending', 'processing', 'completed', 'cancelled'])->default('pending');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
