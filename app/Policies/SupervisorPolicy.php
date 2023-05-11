<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Supervisor;
use Illuminate\Auth\Access\HandlesAuthorization;

class SupervisorPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the supervisor can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list supervisors');
    }

    /**
     * Determine whether the supervisor can view the model.
     */
    public function view(User $user, Supervisor $model): bool
    {
        return $user->hasPermissionTo('view supervisors');
    }

    /**
     * Determine whether the supervisor can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create supervisors');
    }

    /**
     * Determine whether the supervisor can update the model.
     */
    public function update(User $user, Supervisor $model): bool
    {
        return $user->hasPermissionTo('update supervisors');
    }

    /**
     * Determine whether the supervisor can delete the model.
     */
    public function delete(User $user, Supervisor $model): bool
    {
        return $user->hasPermissionTo('delete supervisors');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete supervisors');
    }

    /**
     * Determine whether the supervisor can restore the model.
     */
    public function restore(User $user, Supervisor $model): bool
    {
        return false;
    }

    /**
     * Determine whether the supervisor can permanently delete the model.
     */
    public function forceDelete(User $user, Supervisor $model): bool
    {
        return false;
    }
}
