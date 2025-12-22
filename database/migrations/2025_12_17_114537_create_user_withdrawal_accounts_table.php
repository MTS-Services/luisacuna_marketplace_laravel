<?php

use App\Enums\UserWithdrawalAccountStatus;
use App\Traits\AuditColumnsTrait;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    use AuditColumnsTrait;
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_withdrawal_accounts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sort_order')->default(0)->index();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('withdrawal_method_id');

            $table->string('account_name')->comment('User-defined name for this account');
            $table->json('account_data')->comment('Encrypted account details');
            $table->boolean('is_default')->default(false);
            $table->boolean('is_vsrified')->default(false)->comment('Whether account is verified');
            $table->string('status')->default(UserWithdrawalAccountStatus::PENDING);
            $table->longText('note')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->timestamp('last_used_at')->nullable();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('withdrawal_method_id')->references('id')->on('withdrawal_methods')->onDelete('cascade');


            $table->softDeletes();
            $table->timestamps();

            $this->addMorphedAuditColumns($table);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_withdrawal_accounts');
    }
};
