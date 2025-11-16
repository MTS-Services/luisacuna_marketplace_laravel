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
            $table->unsignedBigInteger('user_id')->index();
            $table->unsignedBigInteger('order_id')->index();

            $table->string('name')->nullable();
            $table->string('email_address')->nullable();
            $table->string('address')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('reference')->unique()->nullable();
            $table->longText('notes')->nullable();

            $table->string('payment_gateway'); // stripe, paypal
            $table->string('transaction_id')->unique();
            $table->string('payment_intent_id')->nullable();
            $table->decimal('amount', 10, 2);
            $table->string('currency', 3)->default('USD');
            $table->string('status')->default(PaymentStatus::PENDING->value);
            $table->text('description')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamp('completed_at')->nullable();

            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete()->cascadeOnUpdate();
            // $table->foreign('order_id')->references('id')->on('orders')->cascadeOnDelete()->cascadeOnUpdate();

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
        Schema::dropIfExists('payments');
    }
};
