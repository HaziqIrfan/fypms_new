<?php

namespace App\Policies;

use App\Models\User;
use App\Models\StudentSubmission;
use Illuminate\Auth\Access\HandlesAuthorization;

class StudentSubmissionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the studentSubmission can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list studentsubmissions');
    }

    /**
     * Determine whether the studentSubmission can view the model.
     */
    public function view(User $user, StudentSubmission $model): bool
    {
        return $user->hasPermissionTo('view studentsubmissions');
    }

    /**
     * Determine whether the studentSubmission can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create studentsubmissions');
    }

    /**
     * Determine whether the studentSubmission can update the model.
     */
    public function update(User $user, StudentSubmission $model): bool
    {
        return $user->hasPermissionTo('update studentsubmissions');
    }

    /**
     * Determine whether the studentSubmission can delete the model.
     */
    public function delete(User $user, StudentSubmission $model): bool
    {
        return $user->hasPermissionTo('delete studentsubmissions');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete studentsubmissions');
    }

    /**
     * Determine whether the studentSubmission can restore the model.
     */
    public function restore(User $user, StudentSubmission $model): bool
    {
        return false;
    }

    /**
     * Determine whether the studentSubmission can permanently delete the model.
     */
    public function forceDelete(User $user, StudentSubmission $model): bool
    {
        return false;
    }
}
