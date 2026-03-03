<?php

namespace App\Livewire\Backend\User\Disputes;

use App\Models\Dispute;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class DisputeResolutionCenter extends Component
{
    use WithFileUploads;

    public Dispute $dispute;

    public string $message = '';

    /**
     * @var array<int,\Livewire\Features\SupportFileUploads\TemporaryUploadedFile>
     */
    public array $files = [];

    public function mount(int $disputeId): void
    {
        $this->dispute = Dispute::query()
            ->with(['order', 'buyer', 'vendor', 'messages.sender', 'attachments'])
            ->findOrFail($disputeId);

        /** @var Authenticatable|null $user */
        $user = Auth::user();

        if (! $user || ! in_array((int) $user->getAuthIdentifier(), [$this->dispute->buyer_id, $this->dispute->vendor_id], true)) {
            abort(403);
        }
    }

    protected function rules(): array
    {
        return [
            'message' => ['nullable', 'string', 'max:5000'],
            'files' => ['array', 'max:5'],
            'files.*' => [
                'file',
                'max:10240',
                'mimes:jpg,jpeg,png,webp,gif,pdf,doc,docx,mp4,mov,webm',
            ],
        ];
    }

    public function send(): void
    {
        $this->validate();

        $trimmed = trim($this->message);

        if ($trimmed === '' && empty($this->files)) {
            return;
        }

        /** @var Authenticatable $user */
        $user = Auth::user();

        $senderRole = (int) $user->getAuthIdentifier() === (int) $this->dispute->buyer_id
            ? 'buyer'
            : 'vendor';

        $message = $this->dispute->messages()->create([
            'sender_id' => $user->getAuthIdentifier(),
            'sender_role' => $senderRole,
            'message' => $trimmed,
            'meta' => [],
        ]);

        if (! empty($this->files)) {
            $disk = config('filesystems.default');

            foreach ($this->files as $index => $file) {
                $path = $file->store("disputes/{$this->dispute->id}/messages", $disk);

                $this->dispute->attachments()->create([
                    'uploaded_by' => $user->getAuthIdentifier(),
                    'disk' => $disk,
                    'path' => $path,
                    'original_name' => $file->getClientOriginalName(),
                    'mime_type' => $file->getMimeType(),
                    'size' => $file->getSize(),
                    'sort_order' => $index,
                    'attachment_type' => null,
                ]);
            }
        }

        $this->reset(['message', 'files']);

        $this->dispute->refresh()->load(['messages.sender', 'attachments']);
    }

    public function refreshMessages(): void
    {
        $this->dispute->refresh()->load(['messages.sender', 'attachments']);
    }

    public function render()
    {
        return view('livewire.backend.user.disputes.dispute-resolution-center');
    }
}

