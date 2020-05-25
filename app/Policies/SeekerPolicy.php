<?php

namespace App\Policies;

use App\Seeker;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SeekerPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //only superadmin can access this
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\Seeker  $seeker
     * @return mixed
     */
    public function view(User $user, Seeker $seeker)
    {
        return $user->is($seeker->user);  //employee can view seeker of his interview
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //only superadmin can access this
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\Seeker  $seeker
     * @return mixed
     */
    public function update(User $user, Seeker $seeker)
    {
        return $user->is($seeker->user);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Seeker  $seeker
     * @return mixed
     */
    public function delete(User $user, Seeker $seeker)
    {
        return $user->is($seeker->user);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\Seeker  $seeker
     * @return mixed
     */
    public function restore(User $user, Seeker $seeker)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Seeker  $seeker
     * @return mixed
     */
    public function forceDelete(User $user, Seeker $seeker)
    {
        //
    }
}
