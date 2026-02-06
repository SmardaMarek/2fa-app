<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('modules', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('title');
            $table->text('description')->nullable();

            $table->string('factor_type');
            $table->string('difficulty')->default('beginner');

            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('user_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('module_id')->constrained('modules')->cascadeOnDelete();
            $table->boolean('theory_completed')->default(false);
            $table->boolean('simulation_setup_completed')->default(false);
            $table->boolean('simulation_attack_completed')->default(false);
            $table->integer('quiz_score')->nullable(); // 0-100 %
            $table->timestamp('completed_at')->nullable(); // Celkové splnění
            $table->timestamps();
            $table->unique(['user_id', 'module_id']);
        });

        Schema::create('mfa_simulations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('module_id')->constrained('modules')->cascadeOnDelete();
            $table->string('scenario_type')->default('setup');
            $table->string('status')->default('initialized');
            $table->json('state_data')->nullable();
            $table->integer('attempts')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mfa_simulations');
        Schema::dropIfExists('user_progress');
        Schema::dropIfExists('modules');
    }
};
