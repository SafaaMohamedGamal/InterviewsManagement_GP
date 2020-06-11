<?php

namespace App\Policies;

use App\Employee;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class EmployeePolicy
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
     * @param  \App\Employee  $employee
     * @return mixed
     */
    public function view(User $current_User, Employee $employee)
    {
        return $current_User->is($employee->user);  //seeker can view employee of his interview
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
     * @param  \App\Employee  $employee
     * @return mixed
     */
    public function edit(User $current_User, Employee $Employee)
    {
        return $current_User->is($Employee->user);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Employee  $employee
     * @return mixed
     */
    public function delete(User $user, Employee $employee)
    {
        return false; //only superadmin can access this
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\Employee  $employee
     * @return mixed
     */
    public function restore(User $user, Employee $employee)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Employee  $employee
     * @return mixed
     */
    public function forceDelete(User $user, Employee $employee)
    {
        //
    }
}
