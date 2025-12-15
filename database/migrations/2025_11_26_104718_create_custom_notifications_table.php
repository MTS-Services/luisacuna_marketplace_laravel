<?php

use App\Enums\CustomNotificationType;
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
        Schema::create('custom_notifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sort_order')->default(0);

            $table->unsignedBigInteger('sender_id')->nullable()->index();
            $table->string('sender_type')->nullable()->index();

            $table->unsignedBigInteger('receiver_id')->nullable()->index();
            $table->string('receiver_type')->nullable()->index();

            $table->string('type')->default(CustomNotificationType::PUBLIC)->index();
            $table->boolean('is_announced')->default(false);
            $table->string('action')->nullable();
            $table->longText('data')->nullable();
            $table->longText('additional')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('custom_notifications');
    }
};
