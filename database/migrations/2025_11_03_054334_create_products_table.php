<?php

use App\Enums\ProductStatus;
use App\Enums\ProductsVisibility;
use App\Traits\AuditColumnsTrait;
use App\Enums\ProductsDeliveryMethod;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    use AuditColumnsTrait;
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sort_order')->default(0)->index();
            $table->unsignedBigInteger('seller_id')->index();
            $table->unsignedBigInteger('game_id')->index();
            $table->unsignedBigInteger('product_type_id')->index();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description');
            $table->decimal('price', 10, 2)->index();
            $table->string('currency')->default('USD');
            $table->decimal('discount_percentage', 5, 2)->default(0.00);
            $table->decimal('discounted_price', 10, 2)->nullable();
            $table->integer('stock_quantity')->default(1);
            $table->integer('min_purchase_quantity')->default(1);
            $table->integer('max_purchase_quantity')->nullable();
            $table->boolean('unlimited_stock')->default(false);
            $table->string('delivery_method')->index()->default(ProductsDeliveryMethod::MANUAL);
            $table->integer('delivery_time_hours')->default(24);
            $table->text('auto_delivery_content')->nullable();
            $table->unsignedBigInteger('server_id')->nullable();
            $table->string('platform')->nullable();
            $table->string('region')->nullable();
            $table->json('specifications')->nullable();
            $table->json('requirements')->nullable();
            $table->string('status')->index()->default(ProductStatus::PENDING_REVIEW);
            $table->boolean('is_featured')->index()->default(false);
            $table->boolean('is_hot_deal')->index()->default(false);
            $table->string('visibility')->index()->default(ProductsVisibility::PUBLIC);
            $table->integer('total_sales')->default(0);
            $table->decimal('total_revenue', 15, 2)->default(0.00);
            $table->integer('view_count')->default(0);
            $table->integer('favorite_count')->default(0);
            $table->decimal('average_rating', 3, 2)->default(0.00);
            $table->integer('total_reviews')->default(0);
            $table->unsignedBigInteger('reviewed_by')->nullable();
            $table->timestamp('reviewed_at')->nullable();
            $table->text('rejection_reason')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();





            $table->foreign('seller_id')->references('id')->on('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('game_id')->references('id')->on('games')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('product_type_id')->references('id')->on('product_types')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('reviewed_by')->references('id')->on('users')->cascadeOnDelete()->cascadeOnUpdate();
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
        Schema::dropIfExists('products');
    }
};
