<?php

namespace App\Livewire\Backend\Admin\ReviewManagement\CmsHelpful;

use Livewire\Component;
use App\Services\CmsService;

class Index extends Component
{
    protected CmsService $service;

    public function boot(CmsService $service): void
    {
        $this->service = $service;
    }

    public function render()
    {
        $pages = $this->service->getAllWithHelpfulStats();

        $totals = [
            'helpful' => $pages->sum('helpful_positive_count'),
            'not_helpful' => $pages->sum('helpful_negative_count'),
        ];
        $totals['total'] = $totals['helpful'] + $totals['not_helpful'];

        return view('livewire.backend.admin.review-management.cms-helpful.index', [
            'pages' => $pages,
            'totals' => $totals,
        ]);
    }
}
