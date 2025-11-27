<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('game_feature_translates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sort_order')->default(0)->index();
            $table->unsignedBigInteger('language_id')->index();

            $table->unsignedBigInteger('game_feature_id')->index();
            $table->string('name')->index();

            $table->timestamps();

            $table->foreign('game_feature_id')->references('id')->on('game_features')->onDelete('cascade');
            $table->foreign('language_id')->references('id')->on('languages')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('game_feature_translates');
    }
};
