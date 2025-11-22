<?php

use App\Traits\AuditColumnsTrait;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
     use AuditColumnsTrait;
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('game_types', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('game_id');
            $table->unsignedBigInteger('type_id')->nullable();
            $table->timestamps();
            $table->foreign('game_id')->references('id')->on('games')->cascadeOnDelete()->cascadeOnUpdate();
            // $table->foreign('type_id')->references('id')->on('types')->cascadeOnDelete()->cascadeOnUpdate();
          
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('game_types');
    }
};
