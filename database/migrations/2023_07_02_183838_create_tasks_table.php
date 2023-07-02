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
            $table->string('name');
            $table->string('description')->nullable();
            $table->date('due_date');
            $table->dateTime('completed_at')->nullable();
            $table->bigInteger('user_id')->unsigned()->index('idx_tasks_user_id');
            $table->foreign('user_id')->references('id')->on('users')
                ->cascadeOnDelete();
            $table->enum('priority', ['low', 'medium', 'high'])->default('low');
            $table->enum('status', ['todo', 'in_progress', 'done'])->default('todo');
            $table->enum('type', ['only', 'daily', 'weekly', 'monthly'])->default('only');
            $table->timestamps();
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
