<?php

use App\Enums\ActiveInactiveEnum;
use App\Enums\WithdrawalFeeType;
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
        Schema::create('withdrawal_methods', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sort_order')->default(0)->index();
            $table->string('name', 100)->unique()->comment('e.g., Payoneer, Bank Transfer, Card');
            $table->string('code', 50)->unique()->comment('e.g., payoneer, bank_transfer')->index();
            $table->text('description')->nullable();
            $table->string('icon')->nullable()->comment('Icon URL or path');
            $table->string('status')->default(ActiveInactiveEnum::ACTIVE)->index();
            $table->decimal('min_amount', 15, 2)->default(0.00)->comment('Minimum withdrawal amount');
            $table->decimal('max_amount', 15, 2)->nullable()->comment('Maximum withdrawal amount');
            $table->decimal('daily_limit', 15, 2)->nullable();
            $table->decimal('weekly_limit', 15, 2)->nullable();
            $table->decimal('monthly_limit', 15, 2)->nullable();
            $table->decimal('per_transaction_limit', 15, 2)->nullable();
            $table->string('processing_time', 100)->nullable()->comment('e.g., 1-3 business days');
            $table->string('fee_type')->default(WithdrawalFeeType::FIXED)->index();
            $table->decimal('fee_amount', 15, 2)->default(0.00);
            $table->decimal('fee_percentage', 5, 2)->default(0.00);
            $table->json('required_fields')->nullable()->comment('Dynamic fields required');

            $table->softDeletes();
            $table->timestamps();

            $this->addAdminAuditColumns($table);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('withdrawal_methods');
    }
};
