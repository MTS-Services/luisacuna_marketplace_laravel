<?php

use App\Enums\ProductTypeStatus;
use App\Traits\AuditColumnsTrait;
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
        Schema::create('product_types', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sort_order')->default(0)->index();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('icon')->nullable();
            $table->boolean('requires_delivery_time')->default(true);
            $table->boolean('requires_server_info')->default(false);
            $table->boolean('requires_character_info')->default(false);
            $table->integer('max_delivery_time_hours')->default(24);
            $table->decimal('commission_rate', 8, 2)->nullable();
            $table->string('status')->index()->default(ProductTypeStatus::ACTIVE);


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
        Schema::dropIfExists('product_types');
    }
};
