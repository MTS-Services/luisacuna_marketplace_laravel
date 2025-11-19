<?php

use App\Enums\AchievementStatus;
use App\Traits\AuditColumnsTrait;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
     use AuditColumnsTrait;
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('achievements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sort_order')->default(0)->index();
            $table->unsignedBigInteger('achievement_type_id');
            $table->unsignedBigInteger('rank_id');
            $table->string('icon')->nullable();
            $table->string('title');
            $table->text('description')->nullable();
            $table->integer('target_value')->nullable();
            $table->integer('point_reward')->nullable();
            $table->string('status')->default(AchievementStatus::ACTIVE)->index();




            $table->foreign('rank_id')->references('id')->on('ranks')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('achievement_type_id')->references('id')->on('achievement_types')->cascadeOnDelete()->cascadeOnUpdate();
            $table->softDeletes();
            $table->timestamps();

            $this->addAdminAuditColumns($table);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('achievements');
    }
};
