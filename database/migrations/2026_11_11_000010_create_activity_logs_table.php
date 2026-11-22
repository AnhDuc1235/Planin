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
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('workspace_id')->constrained('workspaces')->onDelete('cascade');
            $table->foreignId('board_id')->nullable()->constrained('boards')->onDelete('cascade');
            $table->foreignId('task_list_id')->nullable()->constrained('task_lists')->onDelete('set null');
            $table->foreignId('task_id')->nullable()->constrained('tasks')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('action', 50); // vd: created, updated, moved, completed (nhãn: config/planin.php -> activity_actions)
            $table->string('description', 255)->nullable();
            $table->json('properties')->nullable(); // Dữ liệu chi tiết: cột cũ/mới, giá trị cũ/mới...
            $table->timestamps();
            $table->softDeletes();

            $table->index(['board_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
