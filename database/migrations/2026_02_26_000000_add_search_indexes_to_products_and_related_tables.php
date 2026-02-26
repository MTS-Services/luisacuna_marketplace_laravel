<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->index('game_id', 'products_game_id_search_index');
            $table->index('category_id', 'products_category_id_search_index');
            $table->index('user_id', 'products_user_id_search_index');
            $table->index('platform_id', 'products_platform_id_search_index');
            $table->index('status', 'products_status_search_index');
            $table->index('price', 'products_price_search_index');
            $table->index('delivery_timeline', 'products_delivery_timeline_search_index');
            $table->index('quantity', 'products_quantity_search_index');
        });

        Schema::table('product_configs', function (Blueprint $table) {
            $table->index('product_id', 'product_configs_product_id_search_index');
            $table->index('value', 'product_configs_value_search_index');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->index('last_seen_at', 'users_last_seen_at_search_index');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropIndex('products_game_id_search_index');
            $table->dropIndex('products_category_id_search_index');
            $table->dropIndex('products_user_id_search_index');
            $table->dropIndex('products_platform_id_search_index');
            $table->dropIndex('products_status_search_index');
            $table->dropIndex('products_price_search_index');
            $table->dropIndex('products_delivery_timeline_search_index');
            $table->dropIndex('products_quantity_search_index');
        });

        Schema::table('product_configs', function (Blueprint $table) {
            $table->dropIndex('product_configs_product_id_search_index');
            $table->dropIndex('product_configs_value_search_index');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex('users_last_seen_at_search_index');
        });
    }
};

