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
        Schema::create('boards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('workspace_id')->constrained('workspaces')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Người tạo bảng
            $table->string('name', 150);
            // Lưu giá trị CSS (gradient/mã màu) nằm trong danh sách preset config/planin.php -> board_backgrounds
            $table->string('background', 255)->default('linear-gradient(135deg, #0079BF, #5067C5)');
            // Nhãn tiếng Việt: config/planin.php -> enums.board_visibility
            $table->enum('visibility', ['private', 'workspace', 'public'])->default('workspace');
            $table->timestamp('archived_at')->nullable(); // null = đang hoạt động
            $table->timestamps();
            $table->softDeletes();

            $table->index(['workspace_id', 'archived_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('boards');
    }
};
