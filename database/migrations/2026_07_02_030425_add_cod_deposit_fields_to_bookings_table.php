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
        Schema::table('bookings', function (Blueprint $table) {
            $table->unsignedTinyInteger('deposit_percentage')->default(0)->after('payment_status');
            $table->decimal('deposit_amount', 12, 2)->default(0)->after('deposit_percentage');
            $table->decimal('remaining_amount', 12, 2)->default(0)->after('deposit_amount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['deposit_percentage', 'deposit_amount', 'remaining_amount']);
        });
    }
};
