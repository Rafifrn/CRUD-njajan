<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('makanans', function (Blueprint $table) {
            $table->foreignId('tenant_id')->nullable()->after('id')->constrained('tenants')->nullOnDelete();
            $table->enum('category', ['makanan', 'jajanan'])->default('makanan')->after('image');
            $table->boolean('is_available')->default(true)->after('category');
        });
    }

    public function down(): void
    {
        Schema::table('makanans', function (Blueprint $table) {
            $table->dropConstrainedForeignId('tenant_id');
            $table->dropColumn(['category', 'is_available']);
        });
    }
};
