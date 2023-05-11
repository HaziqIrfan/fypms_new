<?php

namespace App\Policies;

use App\Models\User;
use App\Models\EvaluationResult;
use Illuminate\Auth\Access\HandlesAuthorization;

class EvaluationResultPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the evaluationResult can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list evaluationresults');
    }

    /**
     * Determine whether the evaluationResult can view the model.
     */
    public function view(User $user, EvaluationResult $model): bool
    {
        return $user->hasPermissionTo('view evaluationresults');
    }

    /**
     * Determine whether the evaluationResult can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create evaluationresults');
    }

    /**
     * Determine whether the evaluationResult can update the model.
     */
    public function update(User $user, EvaluationResult $model): bool
    {
        return $user->hasPermissionTo('update evaluationresults');
    }

    /**
     * Determine whether the evaluationResult can delete the model.
     */
    public function delete(User $user, EvaluationResult $model): bool
    {
        return $user->hasPermissionTo('delete evaluationresults');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete evaluationresults');
    }

    /**
     * Determine whether the evaluationResult can restore the model.
     */
    public function restore(User $user, EvaluationResult $model): bool
    {
        return false;
    }

    /**
     * Determine whether the evaluationResult can permanently delete the model.
     */
    public function forceDelete(User $user, EvaluationResult $model): bool
    {
        return false;
    }
}
