<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_notification_settings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sort_order')->default(0)->index();
            $table->unsignedBigInteger('user_id');
            $table->boolean('new_order')->default(true);
            $table->boolean('new_message')->default(false);
            $table->boolean('order_update')->default(true);
            $table->boolean('dispute_update')->default(false);
            $table->boolean('payment_update')->default(true);
            $table->boolean('withdrawal_update')->default(false);
            $table->boolean('verification_update')->default(false);
            $table->boolean('boosting_offer')->default(false);

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
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
