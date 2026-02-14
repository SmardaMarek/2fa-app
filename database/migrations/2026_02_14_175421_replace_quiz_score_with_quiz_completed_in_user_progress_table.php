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
        Schema::table('user_progress', function (Blueprint $table) {
            $table->dropColumn('quiz_score');
            $table->boolean('quiz_completed')
                ->default(false)
                ->after('simulation_attack_completed');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_progress', function (Blueprint $table) {
            $table->dropColumn('quiz_completed');
            $table->integer('quiz_score')->nullable()->after('simulation_attack_completed');
        });
    }
};
