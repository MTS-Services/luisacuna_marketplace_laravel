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
        Schema::create('wallet_freezes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sort_order')->default(0)->index();

            $table->unsignedBigInteger('order_id')->nullable()->index();
            $table->unsignedBigInteger('user_id')->nullable()->index();
            $table->unsignedBigInteger('wallet_id')->nullable()->index();

            $table->decimal('amount', 20, 2)->default(0)->index();
            $table->string('currency_code')->index();
            $table->string('status')->index();
            $table->string('reason')->nullable();
            $table->timestamp('frozen_at')->nullable()->index();
            $table->timestamp('released_at')->nullable()->index();
            $table->timestamp('refunded_at')->nullable()->index();
            $table->timestamp('expired_at')->nullable()->index();
            $table->timestamp('cancelled_at')->nullable()->index();
            $table->timestamp('partially_refunded_at')->nullable()->index();
            $table->timestamp('hold_at')->nullable()->index();
            $table->timestamp('split_at')->nullable()->index();

            $table->boolean('is_frozen')->default(false)->index();

            // $table->softDeletes();
            $table->timestamps();

            // $this->addMorphedAuditColumns($table);
            // $this->addAdminAuditColumns($table);

            $table->foreign('order_id')->references('id')->on('orders')->onDelete('set null');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('wallet_id')->references('id')->on('wallets')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallet_freezes');
    }
};
