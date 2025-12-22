<?php

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
        Schema::create('withdrawallimits', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sort_order')->default(0)->index();
            $table->unsignedBigInteger('withdrawal_method_id');
            $table->boolean('is_active')->default(true)->index();

            $table->decimal('daily_limit', 15, 2)->nullable();
            $table->decimal('weekly_limit', 15, 2)->nullable();
            $table->decimal('monthly_limit', 15, 2)->nullable();
            $table->decimal('per_transaction_limit', 15, 2)->nullable();

            $table->integer('max_daily_requests')->nullable();
            $table->integer('max_weekly_requests')->nullable();
            $table->integer('max_monthly_requests')->nullable();
            $table->integer('priority')->default(0)->comment('Higher priority overrides lower');

            $table->foreign('withdrawal_method_id')->references('id')->on('withdrawal_methods')->onDelete('cascade');


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
        Schema::dropIfExists('withdrawallimits');
    }
};
