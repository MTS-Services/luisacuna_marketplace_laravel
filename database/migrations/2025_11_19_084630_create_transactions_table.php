<?php

use App\Enums\TransactionStatus;
use App\Enums\TransactionType;
use App\Traits\AuditColumnsTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sort_order')->default(0)->index();

            // Transaction Identifier
            $table->string('transaction_id', 20)->unique()->index();

            // User Information
            $table->unsignedBigInteger('user_id')->index();

            // Transaction Type & Status
            $table->string('type', 50)->index()->comment('Type: payment, refund, withdrawal, deposit, etc.');
            $table->string('status', 20)->default(TransactionStatus::PENDING->value)->index();
            $table->string('calculation_type', 20)->nullable()->index()->comment('indicates whether the transaction is a credit or debit'); // uses CalculationType enum

            // Amount Details 
            $table->decimal('amount', 20, 2)->index();
            $table->string('currency', 3)->default('USD')->index();

            // Payment Gateway Information (if applicable)
            $table->string('payment_gateway', 50)->nullable()->index();
            $table->string('gateway_transaction_id')->nullable()->index()->comment('External gateway reference ID');

            // Related Order (if applicable)
            $table->unsignedBigInteger('order_id')->nullable()->index();

            // Source Polymorphic Relationship (Payment, Withdrawal, etc.)
            $table->unsignedBigInteger('source_id')->nullable()->index();
            $table->string('source_type')->nullable()->index();

            // Fees & Net Amount
            $table->decimal('fee_amount', 20, 2)->default(0)->comment('Transaction fee if any');
            $table->decimal('net_amount', 20, 2)->default(0)->comment('Amount after fees');

            // Additional Information
            $table->json('metadata')->nullable();
            $table->text('notes')->nullable();
            $table->text('failure_reason')->nullable();

            // Timestamps
            $table->timestamp('processed_at')->nullable()->index();

            $table->timestamps();

            // Foreign Keys
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('set null')->onUpdate('cascade');

            // Composite Indexes
            $table->index(['user_id', 'type', 'status']);
            $table->index(['order_id', 'status']);
            $table->index(['type', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
