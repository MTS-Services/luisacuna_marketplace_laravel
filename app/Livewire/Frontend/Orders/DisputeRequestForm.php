<?php

namespace App\Livewire\Frontend\Orders;

use App\Enums\DisputeStatus;
use App\Livewire\Forms\DisputeRequestForm as DisputeRequestFormObject;
use App\Models\Dispute;
use App\Models\DisputeAttachment;
use App\Models\Order;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('frontend.layouts.app', ['title' => 'Open Dispute'])]
class DisputeRequestForm extends Component
{
    use WithFileUploads;

    public DisputeRequestFormObject $form;

    public ?Order $order = null;

    /**
     * Evidence files uploaded by the buyer.
     *
     * @var array<int,\Livewire\Features\SupportFileUploads\TemporaryUploadedFile>
     */
    public array $evidence = [];

    public function mount(string $orderId): void
    {
        /** @var Authenticatable|null $user */
        $user = Auth::user();

        $this->order = Order::query()
            ->where('order_id', $orderId)
            ->with(['source.user', 'user'])
            ->firstOrFail();

        if (! $user || (int) $this->order->user_id !== (int) $user->getAuthIdentifier()) {
            abort(403);
        }
    }

    protected function rules(): array
    {
        return [
            'evidence' => ['array', 'max:5'],
            'evidence.*' => [
                'file',
                'max:10240',
                'mimes:jpg,jpeg,png,webp,gif,pdf,doc,docx,mp4,mov,webm',
            ],
        ];
    }

    public function submit()
    {
        $data = $this->form->validate();

        $this->validate();

        /** @var Authenticatable $user */
        $user = Auth::user();

        $vendorId = $this->order->source?->user_id;

        $dispute = Dispute::query()->create([
            'order_id' => $this->order->id,
            'buyer_id' => $user->getAuthIdentifier(),
            'vendor_id' => $vendorId,
            'status' => DisputeStatus::PENDING_VENDOR,
            'reason_category' => $data['reason_category'],
            'description' => $data['description'],
        ]);

        $this->order->update([
            'is_disputed' => true,
        ]);

        $this->storeEvidence($dispute);

        $dispute->messages()->create([
            'sender_id' => $user->getAuthIdentifier(),
            'sender_role' => 'buyer',
            'message' => $data['description'],
            'meta' => [
                'status' => $dispute->status->value,
                'system' => false,
            ],
        ]);

        session()->flash('success', __('Your dispute has been submitted.'));

        return redirect()->route('user.disputes.show', $dispute->id);
    }

    protected function storeEvidence(Dispute $dispute): void
    {
        if (empty($this->evidence)) {
            return;
        }

        $disk = config('filesystems.default');

        foreach ($this->evidence as $index => $file) {
            $path = $file->store("disputes/{$dispute->id}", $disk);

            DisputeAttachment::query()->create([
                'dispute_id' => $dispute->id,
                'uploaded_by' => Auth::id(),
                'disk' => $disk,
                'path' => $path,
                'original_name' => $file->getClientOriginalName(),
                'mime_type' => $file->getMimeType(),
                'size' => $file->getSize(),
                'sort_order' => $index,
            ]);
        }
    }

    public function render()
    {
        return view('livewire.frontend.orders.dispute-request-form');
    }
}

