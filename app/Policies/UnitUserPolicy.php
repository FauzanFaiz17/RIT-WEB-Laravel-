<?php

namespace App\Policies;

use App\Models\UnitUser;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class UnitUserPolicy
{
    /**
     * Cek apakah user boleh mengelola anggota di unit tertentu
     */
    private function isLeader(User $user, int $unitId): bool
    {
        return $user->memberships()
            ->where('unit_id', $unitId)
            ->whereHas('role', function ($q) {
                $q->whereIn('name', [
                    'Ketua',
                    'Kepala Divisi',
                ]);
            })
            ->exists();
    }

    /** CREATE */
    public function create(User $user, int $unitId): bool
    {
        return $this->isLeader($user, $unitId);
    }

    /** UPDATE */
    public function update(User $user, UnitUser $unitUser): bool
    {
        return $this->isLeader($user, $unitUser->unit_id);
    }

    /** DELETE */
    public function delete(User $user, UnitUser $unitUser): bool
    {
        return $this->isLeader($user, $unitUser->unit_id);
    }
    
    // /**
    //  * Determine whether the user can view any models.
    //  */
    // public function viewAny(User $user): bool
    // {
    //     return false;
    // }

    // /**
    //  * Determine whether the user can view the model.
    //  */
    // public function view(User $user, UnitUser $unitUser): bool
    // {
    //     return false;
    // }

    // /**
    //  * Determine whether the user can create models.
    //  */
    // public function create(User $user): bool
    // {
    //     return false;
    // }

    // /**
    //  * Determine whether the user can update the model.
    //  */
    // public function update(User $user, UnitUser $unitUser): bool
    // {
    //     return false;
    // }

    // /**
    //  * Determine whether the user can delete the model.
    //  */
    // public function delete(User $user, UnitUser $unitUser): bool
    // {
    //     return false;
    // }

    // /**
    //  * Determine whether the user can restore the model.
    //  */
    // public function restore(User $user, UnitUser $unitUser): bool
    // {
    //     return false;
    // }

    // /**
    //  * Determine whether the user can permanently delete the model.
    //  */
    // public function forceDelete(User $user, UnitUser $unitUser): bool
    // {
    //     return false;
    // }
}
