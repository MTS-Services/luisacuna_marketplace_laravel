<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Models\UserWithdrawalAccount;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use App\Enums\UserWithdrawalAccount as UserWithdrawalAccountEnum;

class UserWithdrawalAccountService
{
    public function __construct(protected UserWithdrawalAccount $model) {}

    /**
     * Get all user withdrawal accounts
     */

    public function getAllDatas($sortField = 'created_at', $order = 'desc', array $with = []): Collection
    {
        return $this->model
            ->query()
            ->with('user', 'withdrawalMethod')
            ->orderBy($sortField, $order)
            ->get();
    }


    public function getPaginatedData(int $perPage = 15, array $filters = []): LengthAwarePaginator
    {
        $search = $filters['search'] ?? null;
        $sortField = $filters['sort_field'] ?? 'created_at';
        $sortDirection = $filters['sort_direction'] ?? 'desc';

        if ($search) {
            return UserWithdrawalAccount::search($search)
                ->query(fn($query) => $query->filter($filters)->orderBy($sortField, $sortDirection))
                ->paginate($perPage);
        }
        return $this->model->query()
            ->with('user', 'withdrawalMethod')
            ->filter($filters)
            ->paginate($perPage);
    }

    //     public function getPaginatedData(int $perPage = 15, array $filters = []): LengthAwarePaginator
    // {
    //     $search = $filters['search'] ?? null;
    //     $sortField = $filters['sort_field'] ?? 'created_at';
    //     $sortDirection = $filters['sort_direction'] ?? 'desc';

    //     if ($search) {
    //         return WithdrawalMethod::search($search)
    //             ->query(fn($query) => $query->filter($filters)->orderBy($sortField, $sortDirection))
    //             ->paginate($perPage);
    //     }

    //     // Normal Eloquent Query
    //     return $this->model->query()
    //         ->filter($filters)
    //         ->orderBy($sortField, $sortDirection)
    //         ->paginate($perPage);
    // }


    public function getUserAccounts(int $userId, array $filters = []): Collection
    {
        $query = $this->model->query()
            ->where('user_id', $userId)
            ->with('withdrawalMethod');

        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (isset($filters['method_id'])) {
            $query->where('withdrawal_method_id', $filters['method_id']);
        }

        return $query->orderBy('is_default', 'desc')
            ->orderBy('sort_order', 'asc')
            ->get();
    }

    /**
     * Find account by ID
     */
    public function findAccount(int $id, int $userId): ?UserWithdrawalAccount
    {
        return $this->model
            ->where('id', $id)
            ->where('user_id', $userId)
            ->first();
    }
    /**
     * Find account by ID
     */
    public function findData(int $id): ?UserWithdrawalAccount
    {
        return $this->model
            ->where('id', $id)
            ->first();
    }
    /**
     * Create new withdrawal account
     */
    public function createAccount(array $data): UserWithdrawalAccount
    {
        return DB::transaction(function () use ($data) {
            // Handle file uploads in account_data
            if (isset($data['account_data'])) {
                $data['account_data'] = json_encode($data['account_data']);
            }
            $account = UserWithdrawalAccount::create($data);

            return $account->fresh();
        });
    }

    /**
     * Update withdrawal account
     */
    public function updateAccount(int $id, int $userId, array $data): ?UserWithdrawalAccount
    {
        return DB::transaction(function () use ($id, $userId, $data) {
            $account = $this->findAccount($id, $userId);

            if (!$account) {
                return null;
            }

            // Handle file uploads
            if (isset($data['account_data'])) {
                $oldData = $account->account_data;

                if (is_string($oldData)) {
                    $decoded = json_decode($oldData, true);
                    $oldData = is_array($decoded) ? $decoded : [];
                }

                $newData = $this->handleFileUploads($data['account_data'], $oldData);
                $data['account_data'] = $newData;
            }

            $account->update($data);

            return $account->fresh();
        });
    }

    // public function updateAccount(UserWithdrawalAccount $account, array $data)
    // {
    //     return $account->update([
    //         'account_name' => $data['account_name'],
    //         'account_data' => $data['account_data'],
    //     ]);
    // }


    /**
     * Delete withdrawal account
     */
    /**
     * Set account as default
     */
    public function setAsDefault(int $id, int $userId): bool
    {
        return DB::transaction(function () use ($id, $userId) {
            // Remove default from all user accounts
            $this->model
                ->where('user_id', $userId)
                ->update(['is_default' => false]);

            // Set new default
            $account = $this->findAccount($id, $userId);

            if (!$account) {
                return false;
            }

            $account->update(['is_default' => true]);

            return true;
        });
    }

    /**
     * Handle file uploads in account data
     */
    protected function handleFileUploads(array $data, ?array $oldData = null): array
    {
        foreach ($data as $key => $value) {
            if ($value instanceof TemporaryUploadedFile) {
                // Delete old file if exists
                if ($oldData && isset($oldData[$key]) && Storage::disk('public')->exists($oldData[$key])) {
                    Storage::disk('public')->delete($oldData[$key]);
                }

                // Store new file
                $prefix = uniqid('WA-') . '-' . time();
                $fileName = $prefix . '-' . $value->getClientOriginalName();
                $path = Storage::disk('public')->putFileAs('withdrawal-accounts', $value, $fileName);

                $data[$key] = $path;
            } elseif ($oldData && isset($oldData[$key])) {
                // Keep old file path if no new upload
                $data[$key] = $oldData[$key];
            }
        }

        return $data;
    }

    /**
     * Verify account
     */
    public function verifyAccount(int $id, array $data): bool
    {
        $account = $this->model->find($id);

        if (!$account) {
            return false;
        }

        return $account->update([
            'is_verified' => true,
            'verified_at' => now(),
            'status' => UserWithdrawalAccountEnum::ACTIVE->value,
            'audit_by' => $data['audit_by'],
            'audit_at' => now(),
        ]);
    }
    public function rejectAccount(int $id, string $note, array $data): bool
    {
        $account = $this->model->find($id);

        if (!$account) {
            return false;
        }

        return $account->update([
            'is_verified' => false,
            'verified_at' => null,
            'status' => UserWithdrawalAccountEnum::DECLINED->value,
            'note' => $note,
            'audit_by' => $data['audit_by'],
            'audit_at' => now(),
        ]);
    }
}
