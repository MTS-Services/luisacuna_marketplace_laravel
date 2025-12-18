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
        Schema::create('withdrawal_methods', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sort_order')->default(0)->index();
            $table->string('name', 100)->unique()->comment('e.g., Payoneer, Bank Transfer, Card');
            $table->string('code', 50)->unique()->comment('e.g., payoneer, bank_transfer')->index();
            $table->text('description')->nullable();
            $table->string('icon')->nullable()->comment('Icon URL or path');
            $table->boolean('is_active')->default(true)->index();
            $table->decimal('min_amount', 15, 2)->default(0.00)->comment('Minimum withdrawal amount');
            $table->decimal('max_amount', 15, 2)->nullable()->comment('Maximum withdrawal amount');
            $table->string('processing_time', 100)->nullable()->comment('e.g., 1-3 business days');
            $table->enum('fee_type', ['fixed', 'percentage', 'mixed'])->default('fixed');
            $table->decimal('fee_amount', 15, 2)->default(0.00);
            $table->decimal('fee_percentage', 5, 2)->default(0.00);
            $table->json('required_fields')->nullable()->comment('Dynamic fields required');
            $table->integer('display_order')->default(0);


            $table->softDeletes();
            $table->timestamps();

            $this->addMorphedAuditColumns($table);
            // $this->addAdminAuditColumns($table);
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
