<?php

use App\Traits\AuditColumnsTrait;
use App\Enums\ReferralSettingStatus;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    use AuditColumnsTrait;
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('referral_settings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sort_order')->default(0);
            $table->string('status')->index()->default(ReferralSettingStatus::ACTIVE->value);
            $table->string('title');
            $table->text('description')->nullable();
            $table->decimal('referrer_bonus', 18, 2)->default(0.00)->comment('the price base on the default currency');
            $table->decimal('referred_bonus', 18, 2)->default(0.00)->comment('the price base on the default currency');
            $table->integer('max_referrals_per_user')->default(0);
            $table->integer('expiry_days')->default(0);

            $table->unsignedBigInteger('currency_id')->nullable();
            $table->foreign('currency_id')->references('id')->on('currencies')->cascadeOnDelete()->cascadeOnUpdate();

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
        Schema::dropIfExists('referral_settings');
    }
};
