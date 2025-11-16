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
        Schema::create('offer_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sort_order')->default(0)->index();

            $table->string('title');
            $table->text('description')->nullable();
            $table->string('image')->nullable();

            $table->timestamp('delivery_time')->nullable();

            $table->unsignedBigInteger('delivery_method_id');
            $table->integer('quantity')->default(0);

            $table->boolean('terms_condition')->default(false);
            $table->boolean('agreement')->default(false);

            $table->decimal('price', 15, 2);

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
        Schema::dropIfExists('offer_items');
    }
};
