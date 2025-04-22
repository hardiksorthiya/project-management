<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();

            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            $table->foreignId('assigned_to')->nullable()->constrained('users')->onDelete('set null');

            $table->string('title');
            $table->text('description')->nullable();

            $table->dateTime('start_at')->nullable();
            $table->dateTime('due_at')->nullable();

            $table->enum('status', ['pending', 'in-progress', 'completed'])->default('pending');
            $table->enum('priority', ['low', 'medium', 'high'])->default('medium');

            $table->timestamps();
        });

        // ✅ Add parent_id FK in a separate schema call to avoid errno 150
        Schema::table('tasks', function (Blueprint $table) {
            $table->foreignId('parent_id')->nullable()->constrained('tasks')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropForeign(['parent_id']);
        });

        Schema::dropIfExists('tasks');
    }
};
