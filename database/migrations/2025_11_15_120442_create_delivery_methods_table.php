<?php

use App\Enums\DeliveryMethodStatus;
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
        Schema::create('delivery_methods', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sort_order')->default(0)->index();

            $table->string('name');
            $table->string('slug')->unique();
            $table->string('image')->nullable();

            $table->string('status')->default(DeliveryMethodStatus::INACTIVE->value);

            $table->softDeletes();
            $table->timestamps();

            // $this->addMorphedAuditColumns($table);
            $this->addAdminAuditColumns($table);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delivery_methods');
    }
};
