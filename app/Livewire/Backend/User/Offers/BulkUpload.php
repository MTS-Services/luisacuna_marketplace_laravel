<?php

namespace App\Livewire\Backend\User\Offers;

use App\Jobs\ProcessBulkOfferUploadJob;
use App\Models\Platform;
use App\Models\Game;
use App\Models\GameConfig;
use App\Services\CategoryService;
use App\Services\GameService;
use App\Services\PlatformService;
use App\Services\ProductService;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\StreamedResponse;

class BulkUpload extends Component
{
    use WithFileUploads;

    public $currentStep = 1;
    public $gameId;
    public $file;
    public $games = [];

    protected GameService $gameService;
    protected ProductService $productService;
    protected CategoryService $categoryService;
    protected PlatformService $platformService;

    public function boot(GameService $gameService, ProductService $productService, CategoryService $categoryService, PlatformService $platformService)
    {
        $this->gameService = $gameService;
        $this->productService = $productService;
        $this->categoryService = $categoryService;
        $this->platformService = $platformService;
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

    public function downloadTemplate(): StreamedResponse
    {
        $game = $this->gameService->findData($this->gameId);

        // -------- Delivery Methods (Readable) --------
        $deliveryMethods = [];
        if ($game->gameConfig->isNotEmpty()) {
            $game->gameConfig->first()->delivery_methods ?? [];
        }
        $timelineOptions = delivery_timelines('manual');
        $platforms = $this->platformService->getActiveData()->pluck('name', 'id')->map(fn($name, $id) => "{$id}:{$name}")->implode(' | ');

        // -------- Categories (id:name format) --------
        $categories = $this->categoryService
            ->getDatas()
            ->pluck('name', 'id')
            ->map(fn($name, $id) => "{$id}:{$name}")
            ->implode(' | ');

        // ---------- Static Headers ----------
        $headers = [
            'Product Title',
            'Description',
            'Quantity',
            'Price',
            'Delivery Method',
            'Delivery Time',
            'Platform',
            'Category'
        ];

        // ---------- Example Row ----------
        $exampleRow = [
            '100 Gold Package',
            'Instant delivery product',
            '1',
            '9.99',
            implode(' / ', $deliveryMethods),
            implode(' / ', $timelineOptions),
            $platforms,
            $categories,
        ];

        // ---------- Dynamic Game Config Headers ----------
        $configs = GameConfig::where('game_id', $this->gameId)->get();

        foreach ($configs as $config) {
            if (!$config->field_name) {
                continue;
            }

            $headers[] = $config->field_name;

            if ($config->input_type === 'select') {
                $options = json_decode($config->options, true);
                $exampleRow[] = implode(' / ', $options ?? []);
            } else {
                $exampleRow[] = 'Enter value';
            }
        }

        return response()->streamDownload(function () use ($headers, $exampleRow) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, $headers);
            fputcsv($handle, $exampleRow);
            fclose($handle);
        }, 'bulk_template_game_' . $this->gameId . '.csv');
    }
    public function uploadFile()
    {
        $this->validate([
            'file'   => 'required|mimes:csv,txt|max:10240',
            'gameId' => 'required|integer',
        ]);

        // file store temporarily
        $path = $this->file->store('bulk-uploads');

        dispatch(new ProcessBulkOfferUploadJob(storage_path('app/' . $path), $this->gameId, user()->id));

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
