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
            // Menghubungkan ke tabel events
            $table->foreignId('event_id')->constrained()->onDelete('cascade');

            // Informasi Pesanan
            $table->string('order_id');
            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('customer_phone');
            $table->integer('total_price');

            // Status Transaksi
            $table->string('status'); // Contoh: 'Pending', 'Success', 'Failed'
            $table->string('snap_token')->nullable(); // Untuk integrasi Midtrans nanti

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
