<?php

namespace Modules\User\Services;

use Modules\User\Models\User;
use Throwable;

class UserService
{
    public function paginate(): \Illuminate\Pagination\LengthAwarePaginator
    {
        return User::paginate();
    }

    public function create(array $data): User
    {
        return User::create($data);
    }

    public function update(User $user, array $data): bool
    {
        return $user->update($data);
    }

    /**
     * @throws Throwable
     */
    public function delete(User $user): ?bool
    {
        return $user->deleteOrFail();
    }
}
