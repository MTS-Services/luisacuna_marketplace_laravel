<?php

use App\Traits\AuditColumnsTrait;
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
        Schema::create('wallet_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sort_order')->default(0)->index();
            $table->unsignedBigInteger('wallet_id')->index();
            $table->unsignedBigInteger('transaction_id')->index();

            $table->string('type', 50)->index()->comment('Type of transaction, e.g., deposit, withdrawal, transfer, etc.'); // uses WalletTransactionType enum
            $table->string('calculation_type', 20)->index()->comment('indicates whether the transaction is a credit or debit'); // uses CalculationType enum
            $table->decimal('amount', 20, 2)->index();
            $table->decimal('balance_after', 20, 2)->index()->comment('Wallet balance after this transaction');
            $table->decimal('balance_before', 20, 2)->index()->comment('Wallet balance before this transaction');
            $table->string('currency_code', 3)->default('USD')->index()->comment('ISO 4217 currency code');
            $table->text('notes')->nullable()->comment('Additional notes or details about the transaction');

            // $table->string('reference_id')->nullable()->index()->comment('Reference ID for external systems or related entities');
            $table->unsignedBigInteger('source_id')->nullable()->index()->comment('ID of the source entity related to this transaction');
            $table->string('source_type')->nullable()->index()->comment('Type of the source entity related to this transaction');

            $table->timestamps();

            $table->foreign('wallet_id')->references('id')->on('wallets')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('transaction_id')->references('id')->on('transactions')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallet_transactions');
    }
};
