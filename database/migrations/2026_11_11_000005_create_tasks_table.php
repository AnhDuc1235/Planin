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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('task_list_id')->constrained('task_lists')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null'); // Người tạo thẻ
            $table->string('title', 255);
            $table->text('description')->nullable();
            // Nhãn tiếng Việt: config/planin.php -> enums.task_priority
            $table->enum('priority', ['low', 'medium', 'high', 'urgent'])->default('medium');
            $table->dateTime('start_date')->nullable();
            $table->dateTime('due_date')->nullable();
            $table->timestamp('completed_at')->nullable(); // null = chưa hoàn thành
            $table->string('cover', 255)->nullable();      // Ảnh bìa thẻ
            $table->integer('position')->default(0);       // Thứ tự của thẻ trong cột
            $table->timestamp('archived_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['task_list_id', 'position']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
