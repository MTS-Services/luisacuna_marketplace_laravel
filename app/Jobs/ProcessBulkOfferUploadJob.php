<?php

namespace App\Jobs;

use App\Models\GameConfig;
use App\Services\ProductService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class ProcessBulkOfferUploadJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected string $filePath;
    protected int $gameId;
    protected int $userId;

    public function __construct(string $filePath, int $gameId, int $userId)
    {
        $this->filePath = $filePath;
        $this->gameId   = $gameId;
        $this->userId   = $userId;
    }

    public function handle(ProductService $productService): void
    {
        $rows = array_map('str_getcsv', file($this->filePath));
        $headers = array_shift($rows);

        DB::beginTransaction();

        try {
            foreach ($rows as $row) {
                if (count($headers) !== count($row)) {
                    continue;
                }

                $csv = array_combine($headers, $row);

                // Platform (id:name)
                [$platformId] = explode(':', $csv['Platform'] ?? '');
                $platformId = (int) $platformId;

                // Category (id:name)
                [$categoryId] = explode(':', $csv['Category'] ?? '');
                $categoryId = (int) $categoryId;

                if (!$platformId || !$categoryId) {
                    continue;
                }

                $productData = [
                    'user_id'           => $this->userId,
                    'game_id'           => $this->gameId,
                    'category_id'       => $categoryId,
                    'platform_id'       => $platformId,
                    'name'              => $csv['Product Title'],
                    'description'       => $csv['Description'],
                    'quantity'          => (int) $csv['Quantity'],
                    'price'             => (float) $csv['Price'],
                    'deliveryMethod'    => trim($csv['Delivery Method']),
                    'delivery_timeline' => trim($csv['Delivery Time']),
                    'fields'            => [],
                ];

                $configs = GameConfig::where('game_id', $this->gameId)
                    ->where('category_id', $categoryId)
                    ->get();

                foreach ($configs as $config) {
                    if (!empty($csv[$config->field_name])) {
                        $productData['fields'][$config->id] = [
                            'value' => trim($csv[$config->field_name]),
                        ];
                    }
                }

                $productService->createData($productData);
            }

            DB::commit();

        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
