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
            $table->string('group_code')->unique(); // kode grup checkout (bisa banyak order multi-tenant)
            $table->string('xendit_invoice_id')->nullable()->index();
            $table->string('status')->default('pending'); // pending | paid | failed | expired
            $table->string('method')->nullable(); // QRIS, VA, dsb (dari Xendit callback)
            $table->string('payment_channel')->nullable();
            $table->decimal('amount', 14, 2);
            $table->string('invoice_url')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
