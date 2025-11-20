<?php

use App\Enums\MethodModeStatus;
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
        Schema::create('withdrawal_gateways', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sort_order')->default(0)->index();

            $table->string('name')->index();
            $table->string('slug')->unique();
            $table->string('icon')->nullable();
            $table->text('data')->nullable();
            $table->boolean('is_active')->index()->default(true);
            $table->string('mode')->index()->default(MethodModeStatus::LIVE->value);
            $table->unsignedBigInteger('updated_by')->nullable()->index();

            $table->timestamps();
            $table->foreign('updated_by')->references('id')->on('admins')->onDelete('set null')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('withdrawal_gateways');
    }
};
