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
        Schema::create('users_notification_settings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sort_order')->default(0)->index();
            $table->unsignedBigInteger('user_id');
            $table->boolean('new_order')->default(false);
            $table->boolean('new_message')->default(false);
            $table->boolean('new_request')->default(false);
            $table->boolean('message_received')->default(false);
            $table->boolean('status_changed')->default(false);
            $table->boolean('request_rejected')->default(false);
            $table->boolean('dispute_created')->default(false);
            $table->boolean('payment_received')->default(false);



            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();

           $this->addMorphedAuditColumns($table);
            // $this->addAdminAuditColumns($table);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users_notification_settings');
    }
};
