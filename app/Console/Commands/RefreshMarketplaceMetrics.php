<?php

namespace App\Console\Commands;

use App\Services\MarketplaceMetricsService;
use Illuminate\Console\Command;

class RefreshMarketplaceMetrics extends Command
{
    protected $signature = 'app:refresh-marketplace-metrics';

    protected $description = 'Recompute Top Selling and Popular flags for products and games';

    public function handle(MarketplaceMetricsService $service): int
    {
        $this->info('Refreshing marketplace metrics...');

        $start = microtime(true);

        $this->components->task('Computing product sales & ratings', fn() => $service->refreshProductMetrics());
        $this->components->task('Flagging Top Selling products', fn() => $service->refreshTopSellingProducts());
        $this->components->task('Flagging Popular games per category', fn() => $service->refreshPopularGames());

        $elapsed = round(microtime(true) - $start, 2);
        $this->newLine();
        $this->info("Marketplace metrics refreshed in {$elapsed}s.");

        return self::SUCCESS;
    }
}
