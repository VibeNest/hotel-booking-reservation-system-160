<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Xoá các bản ghi trùng lặp (nếu có) trước khi thêm unique constraint
        DB::statement('DELETE t1 FROM room_booked_dates t1
            INNER JOIN room_booked_dates t2
            WHERE t1.id > t2.id
            AND t1.room_id = t2.room_id
            AND t1.book_date = t2.book_date');

        Schema::table('room_booked_dates', function (Blueprint $table) {
            $table->unique(['room_id', 'book_date'], 'uq_room_booked_dates_room_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('room_booked_dates', function (Blueprint $table) {
            $table->dropUnique('uq_room_booked_dates_room_date');
        });
    }
};
