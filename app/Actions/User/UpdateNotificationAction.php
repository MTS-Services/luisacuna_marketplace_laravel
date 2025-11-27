<?php

namespace App\Actions\User;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\UsersNotificationSetting;
use App\Repositories\Contracts\UserRepositoryInterface;

class UpdateNotificationAction
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected UserRepositoryInterface $interface
    ) {}

    /**
     * Execute notification setting update
     *
     * @param int $userId
     * @param string $field
     * @param bool $value
     * @return UsersNotificationSetting
     */
    public function execute(int $userId, string $field, bool $value): UsersNotificationSetting
    {
        try {
            return DB::transaction(function () use ($userId, $field, $value) {

                // Validate user exists
                $user = $this->interface->find($userId);

                if (!$user) {
                    Log::error('User not found for notification update', ['user_id' => $userId]);
                    throw new \Exception('User not found');
                }

                // Validate field
                $allowedFields = [
                    'new_order',
                    'new_message',
                    'new_request',
                    'message_received',
                    'status_changed',
                    'request_rejected',
                    'dispute_created',
                    'payment_received'
                ];

                if (!in_array($field, $allowedFields)) {
                    Log::error('Invalid notification field', [
                        'user_id' => $userId,
                        'field' => $field
                    ]);
                    throw new \InvalidArgumentException("Invalid notification field: {$field}");
                }

                // Get notification settings (must exist)
                $notificationSetting = UsersNotificationSetting::where('user_id', $userId)->first();

                if (!$notificationSetting) {
                    Log::error('Notification settings not found', ['user_id' => $userId]);
                    throw new \Exception('Notification settings not found for this user');
                }

                // Store old value for logging
                $oldValue = $notificationSetting->$field ?? false;

                // Update the specific field
                $notificationSetting->update([$field => $value]);

                Log::info('Notification setting updated successfully', [
                    'user_id' => $userId,
                    'field' => $field,
                    'old_value' => $oldValue,
                    'new_value' => $value
                ]);

                return $notificationSetting->fresh();
            });
        } catch (\Exception $e) {
            Log::error('Failed to update notification setting', [
                'user_id' => $userId,
                'field' => $field,
                'value' => $value,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            throw $e;
        }
    }
}
