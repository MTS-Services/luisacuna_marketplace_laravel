<?php

use App\Enums\PaymentStatus;
use App\Traits\AuditColumnsTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    use AuditColumnsTrait, SoftDeletes;
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sort_order')->default(0)->index();
            // Unique Payment Identifier - ADDED!
            $table->string('payment_id', 16)->unique()->index();

            // Customer Information
            $table->unsignedBigInteger('user_id')->index();
            $table->string('name')->nullable();
            $table->string('email_address')->nullable();

            // Payment Gateway Information
            $table->string('payment_gateway', 50)->index();
            $table->string('payment_method_id')->nullable(); // ADDED - Stripe payment method ID
            $table->string('payment_intent_id')->nullable(); // ADDED - Stripe payment intent ID
            $table->string('transaction_id')->nullable()->index(); // ADDED - Final transaction reference

            // Amount Details
            $table->decimal('amount', 15, 2);
            $table->string('currency', 3)->default('USD');
            $table->string('status', 20)->default(PaymentStatus::PENDING)->index();

            // Card Details - ADDED
            $table->string('card_brand', 20)->nullable();
            $table->string('card_last4', 4)->nullable();

            // Order Information
            $table->unsignedBigInteger('order_id')->index();

            // Metadata & Notes
            $table->json('metadata')->nullable();
            $table->text('notes')->nullable();

            // Timestamps
            $table->timestamp('paid_at')->nullable(); // ADDED - When payment completed


            $table->softDeletes();
            $table->timestamps();

            $this->addMorphedAuditColumns($table);
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade')->onUpdate('cascade');

            $table->index(['status', 'created_at']);
            $table->index(['user_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
