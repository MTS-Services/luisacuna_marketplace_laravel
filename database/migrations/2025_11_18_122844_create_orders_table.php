<?php

use App\Enums\OrderStatus;
use App\Traits\AuditColumnsTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    use AuditColumnsTrait, SoftDeletes;
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sort_order')->default(0)->index();
            $table->string('order_id', 16)->unique()->index();
            $table->unsignedBigInteger('user_id')->index();

            $table->unsignedBigInteger('source_id')->index();
            $table->string('source_type')->index();
            $table->string('status')->index()->default(OrderStatus::INITIALIZED->value);

            $table->decimal('unit_price', 20, 2)->default(0);
            $table->decimal('total_amount', 20, 2)->default(0);
            $table->decimal('tax_amount', 20, 2)->default(0);
            $table->decimal('grand_total', 20, 2)->default(0);

            $table->unsignedBigInteger('quantity')->default(1);

            $table->string('currency')->nullable()->index();
            $table->string('payment_method')->nullable();

            // Original prices in default currency
            $table->decimal('default_unit_price', 15, 2)->nullable()->index();
            $table->decimal('default_total_amount', 15, 2)->nullable()->index();
            $table->decimal('default_tax_amount', 15, 2)->nullable()->index();
            $table->decimal('default_grand_total', 15, 2)->nullable()->index();
            $table->string('default_currency', 10)->nullable()->index();
            $table->string('display_symbol', 10)->nullable()->index();
            $table->decimal('exchange_rate', 15, 6)->default(1)->index();
            $table->string('display_currency', 10)->nullable()->index()
                ->comment('Currency displayed to user during checkout');

            $table->text('notes')->nullable();

            $table->boolean('is_disputed')->default(false);

            $table->timestamp('completed_at')->nullable()->index();

            $table->softDeletes();
            $table->timestamps();

            $this->addMorphedAuditColumns($table);

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
