<?php

namespace App\Policies;

use App\Models\AdminHeader;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdminHeaderPolicy
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
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\AdminHeader  $adminHeader
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, AdminHeader $adminHeader)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\AdminHeader  $adminHeader
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, AdminHeader $adminHeader)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\AdminHeader  $adminHeader
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, AdminHeader $adminHeader)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\AdminHeader  $adminHeader
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, AdminHeader $adminHeader)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\AdminHeader  $adminHeader
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, AdminHeader $adminHeader)
    {
        //
    }
}
