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
        Schema::create('disputes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sort_order')->default(0)->index();

            $table->unsignedBigInteger('order_id')->index();
            $table->unsignedBigInteger('buyer_id')->index();
            $table->unsignedBigInteger('vendor_id')->index();

            $table->string('status')->index();
            $table->string('reason_category')->nullable();
            $table->text('description');
            $table->timestamp('resolved_at')->nullable()->index();

            $table->softDeletes();
            $table->timestamps();

            $this->addMorphedAuditColumns($table);

            $table->foreign('order_id')
                ->references('id')
                ->on('orders')
                ->onDelete('cascade');

            $table->foreign('buyer_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('vendor_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('disputes');
    }
};

