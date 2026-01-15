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
        Schema::create('user_achievement_progress', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sort_order')->default(0)->index();
            $table->unsignedBigInteger('user_id')->index();
            $table->unsignedBigInteger('achievement_id')->index();
            $table->integer('current_progress')->default(0);
            $table->timestamp('unlocked_at')->nullable()->index();
            $table->timestamp('achieved_at')->nullable()->index();


            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('achievement_id')->references('id')->on('achievements')->onDelete('cascade');


            $table->timestamps();

            $table->unique(['user_id', 'achievement_id', 'rank_id', 'unlocked_at', 'achieved_at'], 'user_achievement_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_achievement_progress');
    }
};
