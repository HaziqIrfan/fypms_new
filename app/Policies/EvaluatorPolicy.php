<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Evaluator;
use Illuminate\Auth\Access\HandlesAuthorization;

class EvaluatorPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the evaluator can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list evaluators');
    }

    /**
     * Determine whether the evaluator can view the model.
     */
    public function view(User $user, Evaluator $model): bool
    {
        return $user->hasPermissionTo('view evaluators');
    }

    /**
     * Determine whether the evaluator can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create evaluators');
    }

    /**
     * Determine whether the evaluator can update the model.
     */
    public function update(User $user, Evaluator $model): bool
    {
        return $user->hasPermissionTo('update evaluators');
    }

    /**
     * Determine whether the evaluator can delete the model.
     */
    public function delete(User $user, Evaluator $model): bool
    {
        return $user->hasPermissionTo('delete evaluators');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete evaluators');
    }

    /**
     * Determine whether the evaluator can restore the model.
     */
    public function restore(User $user, Evaluator $model): bool
    {
        return false;
    }

    /**
     * Determine whether the evaluator can permanently delete the model.
     */
    public function forceDelete(User $user, Evaluator $model): bool
    {
        return false;
    }
}
