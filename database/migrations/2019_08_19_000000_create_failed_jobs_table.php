<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('failed_jobs', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('job_type')->nullable();           // email, telegram, ai_task, etc.
            $table->unsignedBigInteger('user_id')->nullable(); // kimga bog‘liq
            $table->integer('retry_count')->default(0);        // necha marta uringan
            $table->timestamp('last_attempt_at')->nullable();  // oxirgi urinish
            $table->string('status')->default('failed');       // failed, retrying, permanent-fail

            $table->text('connection');
            $table->text('queue');
            $table->longText('payload');
            $table->longText('exception');
            $table->timestamp('failed_at')->useCurrent();

            // Indexlar
            $table->index(['user_id']);
            $table->index(['status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('failed_jobs');
    }
};
