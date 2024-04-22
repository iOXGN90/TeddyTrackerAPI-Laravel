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
            $table->id('task_id');
            $table->foreignId('admin_id')->constrained('users', 'admin_id')->onDelete('cascade');
            $table->foreignId('section_id')->constrained('sections', 'section_id')->onDelete('cascade');
            $table->string('subject');
            $table->string('task_title');
            $table->string('task_instruction');
            $table->string('type_of_task');
            $table->string('status')->default('progress');
            $table->date('task_deadline'); //yyyy-mm-dd
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

