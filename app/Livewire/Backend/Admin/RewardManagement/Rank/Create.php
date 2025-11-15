<?php

namespace App\Livewire\Backend\Admin\RewardManagement\Rank;

use Livewire\Component;
use App\Enums\RankStatus;
use App\Services\RankService;
use App\Traits\Livewire\WithNotification;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use App\Livewire\Forms\Backend\Admin\RewardManagement\RankForm;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class Create extends Component
{
    use WithNotification, WithFileUploads;
    public RankForm $form;



    protected RankService $service;

    /**
     * Inject the CurrencyService via the boot method.
     */

    public function boot(RankService $service)
    {
        $this->service = $service;
    }

    /**
     * Initialize default form values.
     */
    public function mount(): void
    {
        $this->form->status = RankStatus::ACTIVE->value;
    }




    public function render()
    {
        return view('livewire.backend.admin.reward-management.rank.create', [
            'statuses' => RankStatus::options(),
        ]);
    }


    /**
     * Handle form submission to create a new currency.
     */
    public function save()
    {
        $data = $this->form->validate();

        try {

            $data['created_by'] = admin()->id;

            //Check if minmimum points is less then maximum points

            if ($this->form->minimum_points > $this->form->maximum_points) {


                $this->error('Minimum points should be less then maximum points');

                return;
            }

            //Check the Ranking insert logic
            $old_points = $this->service->getAllDatas('minimum_points', 'asc');
        
            if (count($old_points)) {

                $minimumRanks = $old_points->first();
                $maximumRank = $old_points->last();

                $min = $this->form->minimum_points;

                $valid = (
                    $min < $minimumRanks->minimum_points ||
                    ($min > $maximumRank->maximum_points && $min > $maximumRank->minimum_points)
                );

                if (! $valid) {
                    $minAllowed = $maximumRank->maximum_points ?? $maximumRank->minimum_points;
                    $maxAllowed = $minimumRanks->minimum_points ?? 0;
                    $this->error(
                        "The Rank minimum points should be greater than {$minAllowed} "
                            . "or less than {$maxAllowed}."
                    );
                    return;
                }
            }

            // End



            $this->service->createData($data);

            $this->success('Data created successfully.');

            return $this->redirect(route('admin.rm.rank.index'), navigate: true);
        } catch (\Exception $e) {

            Log::error("Failed to create Rank data", [
                'error' => $e->getMessage(),
            ]);
            $this->error('Failed to create data ');
        }
    }

    /**
     * Cancel creation and redirect back to index.
     */
    public function resetForm(): void
    {
        $this->form->reset();
    }
}
