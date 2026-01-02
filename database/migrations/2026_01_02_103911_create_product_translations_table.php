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
        Schema::create('product_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sort_order')->default(0)->index();
            $table->unsignedBigInteger('language_id')->index();
            $table->unsignedBigInteger('product_id')->index();


            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->text('delivery_timeline')->nullable();
            $table->decimal('price', 15, 2)->default(0)->nullable();
            $table->unsignedBigInteger('quantity')->default(0);


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
        Schema::dropIfExists('product_translations');
    }
};
