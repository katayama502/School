<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('code_runs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('submission_id')->nullable()->constrained()->cascadeOnDelete();
            $table->enum('language', ['python', 'php']);
            $table->string('source_hash');
            $table->longText('stdout')->nullable();
            $table->longText('stderr')->nullable();
            $table->integer('exit_code')->nullable();
            $table->integer('cpu_ms')->nullable();
            $table->integer('mem_kb')->nullable();
            $table->boolean('timed_out')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('code_runs');
    }
};
