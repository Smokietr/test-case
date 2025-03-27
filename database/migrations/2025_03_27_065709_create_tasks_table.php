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
        Schema::create((new \App\Models\Tasks())->getTable(), function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on((new \App\Models\User())->getTable())->onDelete('cascade');
            $table->text('name');
            $table->text('description');
            $table->enum('status', ['pending', 'completed'])->default('pending');
            $table->index(['id', 'user_id', 'status'], 'tasks_index');
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
