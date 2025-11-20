<?php

use App\Enums\RankStatus;
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
        Schema::create('ranks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sort_order')->default(0);
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->unsignedBigInteger('minimum_points')->default(0);
            $table->unsignedBigInteger('maximum_points');
            $table->string('icon')->nullable();
            $table->string('status')->default(RankStatus::ACTIVE->value);
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
        Schema::dropIfExists('ranks');
    }
};
