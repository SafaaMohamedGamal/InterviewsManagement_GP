<?php

namespace App\Policies;

use App\Interview;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class InterviewPolicy
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
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\Interview  $interview
     * @return mixed
     */
    public function view(User $user, Interview $interview)
    {
        return $user->id === $interview->employee->user->id;
        
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\Interview  $interview
     * @return mixed
     */
    public function update(User $user, Interview $interview)
    {
        return $user->id === $interview->employee->user->id;
        
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Interview  $interview
     * @return mixed
     */
    public function delete(User $user, Interview $interview)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\Interview  $interview
     * @return mixed
     */
    public function restore(User $user, Interview $interview)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Interview  $interview
     * @return mixed
     */
    public function forceDelete(User $user, Interview $interview)
    {
        //
    }
}
