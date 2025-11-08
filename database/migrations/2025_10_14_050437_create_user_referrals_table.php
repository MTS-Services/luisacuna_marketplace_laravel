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
        Schema::create('user_referrals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sort_order')->default(0)->index();
            $table->unsignedBigInteger('referral_setting_id');
            $table->unsignedBigInteger('referrer_id');
            $table->unsignedBigInteger('referred_by');

            $table->string('referral_code')->unique();
            $table->decimal('referral_earnings', 10, 2)->default(0.00);
            $table->unsignedBigInteger('currency_id');

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('referral_setting_id')->references('id')->on('referral_settings')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('referrer_id')->references('id')->on('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('referred_by')->references('id')->on('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('currency_id')->references('id')->on('currencies')->cascadeOnDelete()->cascadeOnUpdate();
            $this->addMorphedAuditColumns($table);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_referrals');
    }
};
