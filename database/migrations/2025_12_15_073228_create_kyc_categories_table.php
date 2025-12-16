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
        Schema::create('kyc_categories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sort_order')->default(0)->index();
            $table->unsignedBigInteger('seller_kyc_id')->index();
            $table->unsignedBigInteger('service_category_id')->index();

            $table->timestamps();

            $table->foreign('seller_kyc_id')->references('id')->on('seller_kycs')->onDelete('cascade');
            $table->foreign('service_category_id')->references('id')->on('categories')->onDeleteNull();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kyc_categories');
    }
};
