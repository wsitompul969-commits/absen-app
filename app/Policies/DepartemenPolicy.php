<?php

namespace App\Policies;

use App\Models\Departemen;
use App\Models\User;

class DepartemenPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isAdmin() || $user->isManager();
    }

    public function view(User $user, Departemen $departemen): bool
    {
        return $user->isAdmin() || $user->isManager();
    }

    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    public function update(User $user, Departemen $departemen): bool
    {
        return $user->isAdmin();
    }

    public function delete(User $user, Departemen $departemen): bool
    {
        return $user->isAdmin();
    }

    public function deleteAny(User $user): bool
    {
        return $user->isAdmin();
    }

    public function restore(User $user, Departemen $departemen): bool
    {
        return $user->isAdmin();
    }

    public function forceDelete(User $user, Departemen $departemen): bool
    {
        return $user->isAdmin();
    }
}
