<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Supervisor;
use Illuminate\Auth\Access\HandlesAuthorization;

class SupervisorPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return $user->can('view_any_supervisor');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Supervisor  $supervisor
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Supervisor $supervisor)
    {
        return $user->can('view_supervisor');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->can('create_supervisor');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Supervisor  $supervisor
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Supervisor $supervisor)
    {
        return $user->can('update_supervisor');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Supervisor  $supervisor
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Supervisor $supervisor)
    {
        return $user->can('delete_supervisor');
    }

    /**
     * Determine whether the user can bulk delete.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function deleteAny(User $user)
    {
        return $user->can('delete_any_supervisor');
    }

    /**
     * Determine whether the user can permanently delete.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Supervisor  $supervisor
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Supervisor $supervisor)
    {
        return $user->can('force_delete_supervisor');
    }

    /**
     * Determine whether the user can permanently bulk delete.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDeleteAny(User $user)
    {
        return $user->can('force_delete_any_supervisor');
    }

    /**
     * Determine whether the user can restore.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Supervisor  $supervisor
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Supervisor $supervisor)
    {
        return $user->can('restore_supervisor');
    }

    /**
     * Determine whether the user can bulk restore.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restoreAny(User $user)
    {
        return $user->can('restore_any_supervisor');
    }

    /**
     * Determine whether the user can replicate.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Supervisor  $supervisor
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function replicate(User $user, Supervisor $supervisor)
    {
        return $user->can('replicate_supervisor');
    }

    /**
     * Determine whether the user can reorder.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function reorder(User $user)
    {
        return $user->can('reorder_supervisor');
    }

}
