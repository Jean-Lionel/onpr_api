<?php

namespace App\Policies;

use App\Models\FileDeclaration;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FileDeclarationPolicy
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
     * @param  \App\Models\FileDeclaration  $fileDeclaration
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, FileDeclaration $fileDeclaration)
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
     * @param  \App\Models\FileDeclaration  $fileDeclaration
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, FileDeclaration $fileDeclaration)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\FileDeclaration  $fileDeclaration
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, FileDeclaration $fileDeclaration)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\FileDeclaration  $fileDeclaration
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, FileDeclaration $fileDeclaration)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\FileDeclaration  $fileDeclaration
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, FileDeclaration $fileDeclaration)
    {
        //
    }
}
