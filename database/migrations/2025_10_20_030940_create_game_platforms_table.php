<?php

use App\Enums\GamePlatformStatus;
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
        Schema::create('game_platforms', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sort_order')->default(0)->index();
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->string('status')->default(GamePlatformStatus::ACTIVE->value);
            $table->string('icon')->nullable();
            $table->string('color_code_hex')->nullable();

            $table->softDeletes();
            $table->timestamps();
           // $this->addMorphedAuditColumns($table);
            $this->addAdminAuditColumns($table);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('game_platforms');
    }
};
