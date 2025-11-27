<?php

use App\Traits\AuditColumnsTrait;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    use AuditColumnsTrait;
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('game_configs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sort_order')->default(0)->index();
            $table->unsignedBigInteger('game_id');
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('game_feature_id')->nullable();
            $table->string('value');
            $table->timestamps();

            $table->foreign('game_id')->references('id')->on('games')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('category_id')->references('id')->on('categories')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('game_feature_id')->references('id')->on('game_features')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('game_configs');
    }
};
