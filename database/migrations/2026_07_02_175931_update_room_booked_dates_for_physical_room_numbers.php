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
        if (!Schema::hasColumn('room_booked_dates', 'room_number_id')) {
            Schema::table('room_booked_dates', function (Blueprint $table) {
                $table->integer('room_number_id')->nullable()->after('room_id');
            });
        }

        Schema::table('room_booked_dates', function (Blueprint $table) {
            if ($this->indexExists('room_booked_dates', 'uq_room_booked_dates_room_date')) {
                $table->dropUnique('uq_room_booked_dates_room_date');
            }

            $table->index(['room_id', 'book_date'], 'idx_room_booked_dates_room_date');

            if (!$this->indexExists('room_booked_dates', 'uq_room_booked_dates_room_number_date')) {
                $table->unique(['room_number_id', 'book_date'], 'uq_room_booked_dates_room_number_date');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('room_booked_dates', function (Blueprint $table) {
            if ($this->indexExists('room_booked_dates', 'uq_room_booked_dates_room_number_date')) {
                $table->dropUnique('uq_room_booked_dates_room_number_date');
            }

            if ($this->indexExists('room_booked_dates', 'idx_room_booked_dates_room_date')) {
                $table->dropIndex('idx_room_booked_dates_room_date');
            }
        });

        if (Schema::hasColumn('room_booked_dates', 'room_number_id')) {
            Schema::table('room_booked_dates', function (Blueprint $table) {
                $table->dropColumn('room_number_id');
            });
        }

        Schema::table('room_booked_dates', function (Blueprint $table) {
            if (!$this->indexExists('room_booked_dates', 'uq_room_booked_dates_room_date')) {
                $table->unique(['room_id', 'book_date'], 'uq_room_booked_dates_room_date');
            }
        });
    }

    private function indexExists(string $tableName, string $indexName): bool
    {
        return DB::table('information_schema.statistics')
            ->where('table_schema', DB::getDatabaseName())
            ->where('table_name', $tableName)
            ->where('index_name', $indexName)
            ->exists();
    }
};
