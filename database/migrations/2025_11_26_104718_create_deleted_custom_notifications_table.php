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
        Schema::create('deleted_custom_notifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sort_order')->default(0)->index();

            $table->unsignedBigInteger('actor_id')->index();
            $table->string('actor_type')->index();

            $table->unsignedBigInteger('notification_id')->index();
            $table->foreign('notification_id')->references('id')->on('custom_notifications')->onDelete('cascade')->onUpdate('cascade');

            $table->unique(['id', 'actor_id', 'actor_type'], 'custom_notification_status_index');
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deleted_custom_notifications');
    }
};
