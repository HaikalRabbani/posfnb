<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained();
            $table->enum('method', ['tunai', 'qris', 'transfer']);
            $table->enum('status', ['pending', 'success', 'failed'])->default('pending');
            $table->integer('amount_paid')->nullable();
            $table->integer('change_amount')->nullable();
            $table->string('gateway_name')->nullable(); // Gateway fields nullable untuk tunai
            $table->string('gateway_trx_id')->nullable();
            $table->json('gateway_payload')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};