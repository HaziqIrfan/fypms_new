<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Logbook;
use Illuminate\Auth\Access\HandlesAuthorization;

class LogbookPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the logbook can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list logbooks');
    }

    /**
     * Determine whether the logbook can view the model.
     */
    public function view(User $user, Logbook $model): bool
    {
        return $user->hasPermissionTo('view logbooks');
    }

    /**
     * Determine whether the logbook can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create logbooks');
    }

    /**
     * Determine whether the logbook can update the model.
     */
    public function update(User $user, Logbook $model): bool
    {
        return $user->hasPermissionTo('update logbooks');
    }

    /**
     * Determine whether the logbook can delete the model.
     */
    public function delete(User $user, Logbook $model): bool
    {
        return $user->hasPermissionTo('delete logbooks');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete logbooks');
    }

    /**
     * Determine whether the logbook can restore the model.
     */
    public function restore(User $user, Logbook $model): bool
    {
        return false;
    }

    /**
     * Determine whether the logbook can permanently delete the model.
     */
    public function forceDelete(User $user, Logbook $model): bool
    {
        return false;
    }
}
