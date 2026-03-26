<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained(); // Selalu ada kasir di Fase 1
            $table->string('table_number')->nullable();
            $table->string('order_code')->unique();
            $table->enum('status', ['pending', 'confirmed', 'preparing', 'ready', 'paid', 'cancelled'])->default('pending'); // Alur status order
            $table->integer('total_amount');
            $table->text('notes')->nullable();
            $table->timestamp('ordered_at')->useCurrent();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};