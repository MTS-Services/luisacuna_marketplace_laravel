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

        Schema::create('dispute_orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sort_order')->default(0)->index();
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('disputed_by');
            $table->unsignedBigInteger('disputed_to');
            $table->boolean('is_disputed')->default(false);
            $table->text('reason');
            $table->text('resolution')->nullable();
            $table->timestamps();
            
           $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
           $table->foreign('disputed_by')->references('id')->on('users')->onDelete('cascade');
           $table->foreign('disputed_to')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dispute_orders');
    }
};
