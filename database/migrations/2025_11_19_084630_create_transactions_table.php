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

            // 1. Linking & Auditing
            $table->uuid('correlation_id')->nullable()->index()
                ->comment('Links multiple rows (e.g., Stripe Deposit + Wallet Purchase)');

            $table->string('transaction_id', 50)->unique()->index();
            $table->unsignedBigInteger('user_id')->index();

            // 2. The Transaction Details
            $table->string('type', 50)->index()->comment('Type: PURCHASED, REFUNDED, etc.');
            $table->string('status', 20)->default(TransactionStatus::PENDING->value)->index();
            $table->string('calculation_type', 20)->nullable()->index()->comment('indicates whether the transaction is a credit or debit'); // DEBIT, CREDIT

            // 3. Financial Data (Using your 20,2 precision)
            $table->decimal('amount', 20, 2)->index();
            $table->decimal('fee_amount', 20, 2)->default(0);
            $table->decimal('net_amount', 20, 2)->default(0);
            $table->string('currency', 3)->default('USD');

            // 4. Balance Snapshot (Crucial for accounting)
            $table->decimal('balance_snapshot', 20, 2)->index()
                ->comment('The wallet balance immediately AFTER this transaction occurred');

            // 5. Gateway & Relations
            $table->string('payment_gateway', 50)->nullable()->index(); // 'stripe', 'crypto', 'wallet'
            $table->string('gateway_transaction_id')->nullable()->index();
            $table->unsignedBigInteger('order_id')->nullable()->index();

            // Source Polymorphic Relationship (Payment, Withdrawal, etc.)
            $table->unsignedBigInteger('source_id')->nullable()->index();
            $table->string('source_type')->nullable()->index();

            // Fees & Net Amount

            // Additional Information
            $table->json('metadata')->nullable();
            $table->text('notes')->nullable();
            $table->text('failure_reason')->nullable();
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
