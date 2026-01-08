<?php

use App\Traits\AuditColumnsTrait;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    use AuditColumnsTrait;

    public function up(): void
    {
        Schema::create('devices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sort_order')->default(0)->index();

            // Polymorphic relation (User or Admin)
            $table->unsignedBigInteger('source_id')->index();
            $table->string('source_type')->index();

            // Device identification
            $table->string('fcm_token')->nullable()->index();
            $table->string('device_type')->default('web')->index(); // ios, android, web
            $table->string('device_name')->nullable();
            $table->string('device_model')->nullable();
            $table->string('os_version')->nullable();
            $table->string('app_version')->nullable();

            // Session tracking
            $table->string('session_id')->unique()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();

            // Status tracking
            $table->boolean('is_active')->default(true)->index();
            $table->timestamp('last_used_at')->nullable();
            $table->timestamp('logged_out_at')->nullable();

            // Security
            $table->string('device_fingerprint')->nullable()->index(); // Unique device identifier

            $table->softDeletes();
            $table->timestamps();

            // Composite index for faster queries
            $table->index(['source_type', 'source_id', 'is_active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('devices');
    }
};
