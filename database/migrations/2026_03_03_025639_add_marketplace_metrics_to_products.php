<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->unsignedInteger('sales_count_30d')->default(0)->after('quantity');
            $table->decimal('average_rating', 3, 2)->default(0)->after('sales_count_30d');
            $table->boolean('is_top_selling')->default(false)->index()->after('average_rating');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropIndex(['is_top_selling']);
            $table->dropColumn(['sales_count_30d', 'average_rating', 'is_top_selling']);
        });
    }
};
