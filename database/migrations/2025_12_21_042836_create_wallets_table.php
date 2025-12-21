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
        Schema::create('wallets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sort_order')->default(0)->index();

            $table->unsignedBigInteger('user_id')->unique()->index();
            $table->string('currency_code', 5)->default('USD')->index()->comment('ISO 4217 currency code');
            $table->decimal('balance', 20, 2)->default(0)->index();
            $table->decimal('locked_balance', 20, 2)->default(0)->index();
            $table->decimal('pending_balance', 20, 2)->default(0)->index();

            $table->decimal('total_deposits', 20, 2)->default(0)->index();
            $table->decimal('total_withdrawals', 20, 2)->default(0)->index();

            $table->timestamp('last_deposit_at')->nullable()->index();
            $table->timestamp('last_withdrawal_at')->nullable()->index();

            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallets');
    }
};
