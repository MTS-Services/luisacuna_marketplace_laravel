<?php

namespace App\Livewire\Backend\User\Messages;

use App\Services\ConversationService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Livewire\Component;

class MessageNotificaitonSidebar extends Component
{
    public $MessageNotificationShow = false;
    public Collection $conversations ;
    public bool $isLoading = false;
    
    protected ConversationService $service;
    public function boot(ConversationService $service): void
    {
     $this->service = $service;   
    }
    public function mount(){
         $this->conversations = new Collection();
    }
    public function render()
    {
        return view('livewire.backend.user.messages.message-notificaiton-sidebar', [
            'conversations' => $this->conversations
        ]);
    }



    #[On('user-message-notification-show')]
    public function openMessageNotificationSidebar(): void
    {
        $this->MessageNotificationShow = true;
        $this->fetchMessage();


    }

    public function fetchMessage(){
          try {
            $this->isLoading = true;
            $this->conversations = $this->service->fetchConversationList();
        } catch (\Exception $e) {
            Log::error('Failed to fetch notifications', [
                'error' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
            ]);
            $this->conversations = new Collection();
        } finally {
            $this->isLoading = false;
        }
    }


    public function markAllAsRead(){
        
    }
  public function getListeners(): array
    {
        return [
            'user-message-notification-show' => 'openMessageNotificationSidebar',
            'message-received' => 'refreshMessages',
            'message-created' => 'refreshMessages',
        ];
    }
}
