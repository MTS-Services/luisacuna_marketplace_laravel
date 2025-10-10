<?php

namespace App\Repositories\Eloquent\User;

use App\Enums\UserStatus;
use App\Models\User;
use App\Repositories\Contracts\User\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class UserRepository extends UserRepositoryInterface
{
    public function __construct(protected User $model) {}

    public function all()
    {
        return $this->model->latest()->get();
    }

    public function paginate(int $perPage = 15)
    {
        return $this->model->latest()->paginate($perPage);
    }

    public function find(int $id)
    {
        return $this->model->find($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data)
    {
        $user = $this->find($id);
        $user->update($data);
        return $user->refresh();
    }

    public function delete(int $id)
    {
        return $this->model->destroy($id);
    }

    public function search(string $query)
    {
        return $this->model->where('name', 'like', "%{$query}%")
            ->orWhere('email', 'like', "%{$query}%")
            ->latest()
            ->get();
    }
    public function findByEmail(string $email)
    {
        return $this->model->where('email', '=', $email)->first();
    }

    public function getActiveUsers(): Collection
    {
        return $this->model
            ->where('status', UserStatus::Active->value)
            ->latest()
            ->get();
    }
}
