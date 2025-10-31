<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();
            $table->foreignId('assignment_id')->constrained()->cascadeOnDelete();
            $table->enum('type', ['code', 'scratch']);
            $table->enum('status', ['draft', 'submitted', 'returned', 'accepted'])->default('draft');
            $table->unsignedInteger('score')->nullable();
            $table->text('feedback')->nullable();
            $table->string('content_ref')->nullable();
            $table->json('run_stats')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('submissions');
    }
};
