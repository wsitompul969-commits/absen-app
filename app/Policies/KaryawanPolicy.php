<?php

namespace App\Policies;

use App\Models\Karyawan;
use App\Models\User;

class KaryawanPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isAdmin() || $user->isManager() || $user->isEmployee();
    }

    public function view(User $user, Karyawan $karyawan): bool
    {
        return $user->isAdmin()
            || $user->isManager()
            || ($user->isEmployee() && $karyawan->user_id === $user->getKey());
    }

    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    public function update(User $user, Karyawan $karyawan): bool
    {
        return $user->isAdmin()
            || ($user->isEmployee() && $karyawan->user_id === $user->getKey());
    }

    public function delete(User $user, Karyawan $karyawan): bool
    {
        return $user->isAdmin();
    }

    public function deleteAny(User $user): bool
    {
        return $user->isAdmin();
    }

    public function restore(User $user, Karyawan $karyawan): bool
    {
        return $user->isAdmin();
    }

    public function forceDelete(User $user, Karyawan $karyawan): bool
    {
        return $user->isAdmin();
    }
}
