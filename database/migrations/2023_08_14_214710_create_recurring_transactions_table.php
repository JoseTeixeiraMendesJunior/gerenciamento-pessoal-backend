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
        Schema::create('recurring_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->decimal('amount', 10, 2);
            $table->enum('type', ['expense', 'income']);
            $table->bigInteger('user_id')->unsigned()->index('idx_recurring_transactions_user_id');
            $table->foreign('user_id')->references('id')->on('users')
                ->cascadeOnDelete();
            $table->bigInteger('transaction_category_id')->unsigned()->index('idx_recurring_transaction_category_id');
            $table->foreign('transaction_category_id')->references('id')->on('transaction_categories')
                ->cascadeOnDelete();
            $table->date('date');
            $table->enum('frequency', ['daily', 'weekly', 'monthly']);
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recurring_transactions');
    }
};
