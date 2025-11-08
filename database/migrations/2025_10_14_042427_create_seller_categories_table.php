<?php

use App\Traits\AuditColumnsTrait;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\SoftDeletes;

return new class extends Migration {
    use AuditColumnsTrait, SoftDeletes;
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('seller_categories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sort_order')->default(0)->index();
            $table->unsignedBigInteger('seller_profile_id');
            $table->unsignedBigInteger('game_categories_id');

            $table->softDeletes();
            $table->timestamps();
            $this->addMorphedAuditColumns($table);

            $table->unique(['seller_profile_id', 'game_categories_id'], 'seller_category_unique');

            $table->foreign('seller_profile_id')->references('id')->on('seller_profiles')->onDelete('cascade');
            $table->foreign('game_categories_id')->references('id')->on('game_categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seller_categories');
    }
};
