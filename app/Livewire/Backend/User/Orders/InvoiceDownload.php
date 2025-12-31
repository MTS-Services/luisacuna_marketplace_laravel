<?php

namespace App\Livewire\Backend\User\Orders;

use Livewire\Component;
use App\Services\OrderService;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceDownload extends Component
{

    public $showDeleteModal = false;
    public $deleteItemId = null;
    public $perPage = 7;
    public $status;
    public $order_date;
    public $search;
    public $months = [];
    public $selectedMonth;
    public $fileType = 'pdf';


    protected OrderService $service;

    public function boot(OrderService $service)
    {
        $this->service = $service;
    }
    public function mount()
    {
        $this->months = $this->generateMonthOptions();
        $this->selectedMonth = $this->months[0]['value'] ?? null;
    }
    public function render()
    {
        return view('livewire.backend.user.orders.invoice-download');
    }


    private function generateMonthOptions(): array
    {
        $months = [];
        $user = user();

        $startDate = $user->created_at->copy()->startOfMonth();
        $currentDate = now()->startOfMonth();

        $totalMonths = $startDate->diffInMonths($currentDate) + 1;

        for ($i = 0; $i < $totalMonths; $i++) {
            $date = $currentDate->copy()->subMonths($i);

            $months[] = [
                'value' => $date->format('Y-m'),
                'label' => $date->format('F Y')
            ];
        }

        return $months;
    }
    public function downloadInvoice()
    {
        if (!$this->selectedMonth) {
            abort(400, 'Month not selected');
        }

        [$year, $month] = explode('-', $this->selectedMonth);

        $orders = $this->service->getOrdersByMonthForSeller(
            sellerId: user()->id,
            month: (int) $month,
            year: (int) $year
        );

        // ✅ CSV
        if ($this->fileType === 'csv') {
            return response()->streamDownload(function () use ($orders) {

                $handle = fopen('php://output', 'w');

                fputcsv($handle, [
                    'Order ID',
                    'Product',
                    'Buyer',
                    'Quantity',
                    'Amount',
                    'Status',
                    'Date',
                ]);

                foreach ($orders as $order) {
                    fputcsv($handle, [
                        $order->order_id,
                        $order->source->name ?? '',
                        $order->user->full_name ?? '',
                        $order->total_quantity,
                        $order->total_amount,
                        $order->status->label(),
                        $order->created_at->format('Y-m-d'),
                    ]);
                }

                fclose($handle);
            }, "sales-invoice-{$year}-{$month}.csv");
        }

        // ✅ PDF
        if ($this->fileType === 'pdf') {
            $pdf = Pdf::loadView('pdf-template.invoice', [
                'orders' => $orders,
                'month'  => $month,
                'year'   => $year,
                'seller' => user(),
            ]);

            return response()->streamDownload(
                fn() => print($pdf->output()),
                "sales-invoice-{$year}-{$month}.pdf"
            );
        }

        abort(400, 'Invalid file type');
    }
}
