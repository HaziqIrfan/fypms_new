<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Evaluation;
use Illuminate\Auth\Access\HandlesAuthorization;

class EvaluationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the evaluation can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list evaluations');
    }

    /**
     * Determine whether the evaluation can view the model.
     */
    public function view(User $user, Evaluation $model): bool
    {
        return $user->hasPermissionTo('view evaluations');
    }

    /**
     * Determine whether the evaluation can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create evaluations');
    }

    /**
     * Determine whether the evaluation can update the model.
     */
    public function update(User $user, Evaluation $model): bool
    {
        return $user->hasPermissionTo('update evaluations');
    }

    /**
     * Determine whether the evaluation can delete the model.
     */
    public function delete(User $user, Evaluation $model): bool
    {
        return $user->hasPermissionTo('delete evaluations');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete evaluations');
    }

    /**
     * Determine whether the evaluation can restore the model.
     */
    public function restore(User $user, Evaluation $model): bool
    {
        return false;
    }

    /**
     * Determine whether the evaluation can permanently delete the model.
     */
    public function forceDelete(User $user, Evaluation $model): bool
    {
        return false;
    }
}
