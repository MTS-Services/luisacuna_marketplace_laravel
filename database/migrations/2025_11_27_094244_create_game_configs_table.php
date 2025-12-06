<?php

use App\Enums\GameConfigFilterType;
use App\Enums\GameConfigInputType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('game_configs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sort_order')->default(0)->index();
            $table->unsignedBigInteger('game_id')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('game_category_id');
            $table->string('field_name');
            $table->string('slug')->index();
            $table->string('filter_type')->default(GameConfigFilterType::NO_FILTER->value);
            $table->string('input_type')->default(GameConfigInputType::TEXT->value);
            $table->json('dropdown_values')->nullable();
            $table->json('delivery_methods');
            $table->timestamps();

            $table->foreign('game_id')->references('id')->on('games')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('category_id')->references('id')->on('categories')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('game_category_id')->references('id')->on('game_categories')->cascadeOnDelete()->cascadeOnUpdate();
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
