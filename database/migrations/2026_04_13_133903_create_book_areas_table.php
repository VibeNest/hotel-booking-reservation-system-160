<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('book_areas', function (Blueprint $table) {
            $table->id();
            $table->string('sub_title')->nullable();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->string('link_url')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book_areas');
    }
};
