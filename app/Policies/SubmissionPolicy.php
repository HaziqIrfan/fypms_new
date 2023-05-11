<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Submission;
use Illuminate\Auth\Access\HandlesAuthorization;

class SubmissionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the submission can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list submissions');
    }

    /**
     * Determine whether the submission can view the model.
     */
    public function view(User $user, Submission $model): bool
    {
        return $user->hasPermissionTo('view submissions');
    }

    /**
     * Determine whether the submission can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create submissions');
    }

    /**
     * Determine whether the submission can update the model.
     */
    public function update(User $user, Submission $model): bool
    {
        return $user->hasPermissionTo('update submissions');
    }

    /**
     * Determine whether the submission can delete the model.
     */
    public function delete(User $user, Submission $model): bool
    {
        return $user->hasPermissionTo('delete submissions');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete submissions');
    }

    /**
     * Determine whether the submission can restore the model.
     */
    public function restore(User $user, Submission $model): bool
    {
        return false;
    }

    /**
     * Determine whether the submission can permanently delete the model.
     */
    public function forceDelete(User $user, Submission $model): bool
    {
        return false;
    }
}
