<?php

namespace App\Livewire\Backend\User\Offers;

use Livewire\Component;
use App\Models\GameConfig;
use App\Exports\ArrayExport;
use App\Services\GameService;
use Livewire\WithFileUploads;
use App\Services\CategoryService;
use App\Services\PlatformService;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Jobs\ProcessBulkOfferUploadJob;
use App\Services\ProductService;
use Illuminate\Support\Facades\Storage;

class BulkUpload extends Component
{
    use WithFileUploads;

    public $currentStep = 1;
    public $gameId;
    public $file;
    public $games = [];
    public $format = 'csv'; // csv | excel

    protected GameService $gameService;
    protected CategoryService $categoryService;
    protected PlatformService $platformService;
    protected ProductService $productService;

    public function boot(
        GameService $gameService,
        CategoryService $categoryService,
        PlatformService $platformService,
        ProductService $productService
    ) {
        $this->gameService = $gameService;
        $this->categoryService = $categoryService;
        $this->platformService = $platformService;
        $this->productService = $productService;
    }

    public function selectUploadMethod($method)
    {
        if ($method == 'csv') {
            $this->games = $this->gameService->getAllDatas();
            $this->currentStep = 2;
        }
    }

    public function selectGame()
    {
        if (!$this->gameId) {
            $this->addError('gameId', 'Please select a game.');
            return;
        }
        $this->currentStep = 3;
    }

    /**
     * CSV / Excel Template Download
     */
    public function downloadTemplate($method = 'csv')
    {
        $game = $this->gameService->findData($this->gameId);

        $platforms = $this->platformService
            ->getActiveData()
            ->pluck('name', 'id')
            ->map(fn($name, $id) => "{$id}:{$name}")
            ->implode(' | ');

        $categories = $this->categoryService
            ->getDatas()
            ->pluck('name', 'id')
            ->map(fn($name, $id) => "{$id}:{$name}")
            ->implode(' | ');

        if ($method === 'csv') {
            $export = new ArrayExport($game, $platforms, $categories);
            return response()->streamDownload(function () use ($export) {
                $handle = fopen('php://output', 'w');
                fputcsv($handle, $export->headings());
                foreach ($export->array() as $row) {
                    fputcsv($handle, $row);
                }
                fclose($handle);
            }, "bulk_template_game_{$this->gameId}.csv");
        }

        // Excel
        return Excel::download(new ArrayExport($game, $platforms, $categories), 'bulk_template_game_' . $this->gameId . '.xlsx');
    }


    /**
     * Upload CSV / Excel
     */
    // public function uploadFile()
    // {
    //     $this->validate([
    //         'file'   => 'required|mimes:csv,xlsx|max:10240',
    //         'gameId' => 'required|integer',
    //     ]);

    //     $path = $this->file->store('bulk-uploads');

    //     ProcessBulkOfferUploadJob::dispatch(
    //         storage_path('app/' . $path),
    //         $this->gameId,
    //         user()->id
    //     )->onQueue('bulk-upload');

    //     session()->flash(
    //         'success',
    //         'Bulk upload is processing in background. You will see offers shortly.'
    //     );

    //     $this->reset(['file']);
    // }

    public function uploadFile()
    {
        $this->validate([
            'file'   => 'required|mimes:csv,xlsx|max:10240',
            'gameId' => 'required|integer',
        ]);

        $path = $this->file->store('bulk-uploads', 'local');

        $fullPath = Storage::path($path);

        $rows = array_map('str_getcsv', file($fullPath));
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
                    'user_id'           => user()->id,
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

                $this->productService->createData($productData);
            }

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }

        session()->flash(
            'success',
            'Bulk upload is processing in background. You will see offers shortly.'
        );

        $this->reset(['file']);
    }
    public function render()
    {
        return view('livewire.backend.user.offers.bulk-upload');
    }
}
