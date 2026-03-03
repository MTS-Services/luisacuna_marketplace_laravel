<?php

namespace App\Services;

use App\Enums\OrderStatus;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MarketplaceMetricsService
{
    /**
     * Refresh all marketplace metric flags.
     */
    public function refreshAll(): void
    {
        $this->refreshProductMetrics();
        $this->refreshTopSellingProducts();
        $this->refreshPopularGames();
    }

    /**
     * Recompute sales_count_30d and average_rating for every product
     * using aggregated queries on completed orders and feedback.
     */
    public function refreshProductMetrics(): void
    {
        $thirtyDaysAgo = now()->subDays(30)->toDateTimeString();
        $completedStatus = OrderStatus::COMPLETED->value;
        $productMorphType = (new Product())->getMorphClass();

        DB::statement("
            UPDATE products p
            LEFT JOIN (
                SELECT
                    o.source_id AS product_id,
                    COALESCE(SUM(o.quantity), 0) AS total_sales
                FROM orders o
                WHERE o.source_type = ?
                  AND o.status = ?
                  AND o.completed_at >= ?
                  AND o.deleted_at IS NULL
                GROUP BY o.source_id
            ) sales ON sales.product_id = p.id
            LEFT JOIN (
                SELECT
                    o.source_id AS product_id,
                    COALESCE(AVG(f.rating), 0) AS avg_rating
                FROM feedback f
                INNER JOIN orders o ON o.id = f.order_id
                WHERE o.source_type = ?
                  AND f.deleted_at IS NULL
                GROUP BY o.source_id
            ) ratings ON ratings.product_id = p.id
            SET
                p.sales_count_30d = COALESCE(sales.total_sales, 0),
                p.average_rating  = COALESCE(ratings.avg_rating, 0)
        ", [
            $productMorphType,
            $completedStatus,
            $thirtyDaysAgo,
            $productMorphType,
        ]);

        Log::info('[MarketplaceMetrics] Product metrics (sales_count_30d, average_rating) refreshed.');
    }

    /**
     * Flag the top 5% of products per game as "Top Selling".
     * Uses: score = (sales_count_30d * 0.8) + (average_rating * 0.2)
     * Window function PERCENT_RANK() partitioned by game_id.
     */
    public function refreshTopSellingProducts(): void
    {
        DB::statement('UPDATE products SET is_top_selling = 0');

        DB::statement("
            UPDATE products p
            INNER JOIN (
                SELECT
                    ranked.id
                FROM (
                    SELECT
                        id,
                        game_id,
                        (sales_count_30d * 0.8) + (average_rating * 0.2) AS score,
                        PERCENT_RANK() OVER (
                            PARTITION BY game_id
                            ORDER BY (sales_count_30d * 0.8) + (average_rating * 0.2) ASC
                        ) AS pct_rank
                    FROM products
                    WHERE game_id IS NOT NULL
                      AND deleted_at IS NULL
                ) ranked
                WHERE ranked.pct_rank >= 0.95
                  AND ranked.score > 0
            ) top_products ON top_products.id = p.id
            SET p.is_top_selling = 1
        ");

        Log::info('[MarketplaceMetrics] Top Selling product flags refreshed.');
    }

    /**
     * Flag the top 3 games per category as "Popular" in the game_categories pivot.
     * Popularity = sum of sales_count_30d for all products of that game within that category.
     */
    public function refreshPopularGames(): void
    {
        DB::statement('UPDATE game_categories SET is_popular = 0');

        DB::statement("
            UPDATE game_categories gc
            INNER JOIN (
                SELECT
                    ranked.game_id,
                    ranked.category_id
                FROM (
                    SELECT
                        gc2.game_id,
                        gc2.category_id,
                        COALESCE(SUM(p.sales_count_30d), 0) AS total_sales,
                        ROW_NUMBER() OVER (
                            PARTITION BY gc2.category_id
                            ORDER BY COALESCE(SUM(p.sales_count_30d), 0) DESC
                        ) AS rank_num
                    FROM game_categories gc2
                    INNER JOIN products p
                        ON p.game_id = gc2.game_id
                       AND p.category_id = gc2.category_id
                       AND p.deleted_at IS NULL
                    GROUP BY gc2.game_id, gc2.category_id
                ) ranked
                WHERE ranked.rank_num <= 3
                  AND ranked.total_sales > 0
            ) popular ON popular.game_id = gc.game_id
                     AND popular.category_id = gc.category_id
            SET gc.is_popular = 1
        ");

        Log::info('[MarketplaceMetrics] Popular game flags refreshed.');
    }
}
