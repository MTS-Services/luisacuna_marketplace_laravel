<?php

namespace App\Livewire\Backend\User\Offers;

use Livewire\Component;
use App\Exports\ArrayExport;
use App\Services\GameService;
use Livewire\WithFileUploads;
use App\Services\CategoryService;
use App\Services\PlatformService;
use Maatwebsite\Excel\Facades\Excel;
use App\Jobs\ProcessBulkOfferUploadJob;

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

    public function boot(
        GameService $gameService,
        CategoryService $categoryService,
        PlatformService $platformService
    ) {
        $this->gameService = $gameService;
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
    public function uploadFile()
    {
        $this->validate([
            'file'   => 'required|mimes:csv,xlsx|max:10240',
            'gameId' => 'required|integer',
        ]);

        $path = $this->file->store('bulk-uploads');

        ProcessBulkOfferUploadJob::dispatch(
            storage_path('app/' . $path),
            $this->gameId,
            user()->id
        )->onQueue('bulk-upload');

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
