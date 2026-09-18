<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->foreignId('tenant_id')->nullable()->after('user_id')->constrained('tenants')->nullOnDelete();
            $table->string('status')->default('pending')->change(); // pending | diproses | selesai
            $table->string('kode')->nullable()->unique()->after('id'); // kode pesanan pelanggan
            $table->string('payment_group')->nullable()->index()->after('kode'); // grup checkout (1 pembayaran multi-tenant)
            $table->string('payment_status')->default('unpaid')->after('status'); // unpaid | paid
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['payment_status', 'kode']);
            $table->dropConstrainedForeignId('tenant_id');
        });
    }
};
