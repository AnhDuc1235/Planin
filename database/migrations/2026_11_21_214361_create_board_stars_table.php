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
        Schema::create('board_stars', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('board_id')->constrained('boards')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();

            // Mỗi người chỉ gắn sao 1 lần cho 1 bảng
            $table->unique(['user_id', 'board_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('board_stars');
    }
};
