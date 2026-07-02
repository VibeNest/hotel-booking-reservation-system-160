<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Xoá các bản ghi trùng lặp (nếu có) trước khi thêm unique constraint
        // Sử dụng subquery để tương thích với cả MySQL và SQLite
        $duplicateIds = DB::table('room_booked_dates as t1')
            ->select('t1.id')
            ->join('room_booked_dates as t2', function ($join) {
                $join->on('t1.room_id', '=', 't2.room_id')
                    ->on('t1.book_date', '=', 't2.book_date')
                    ->where('t1.id', '>', 't2.id');
            })
            ->get()->pluck('id');

        if ($duplicateIds->isNotEmpty()) {
            DB::table('room_booked_dates')->whereIn('id', $duplicateIds)->delete();
        }

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
