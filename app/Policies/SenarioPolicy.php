<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\Senario;
use Illuminate\Auth\Access\HandlesAuthorization;

class SenarioPolicy
{
    use HandlesAuthorization;
    
    /**
     * Determine whether the user can view any senarios.
     *
     * @param  \App\Models\Admin  $user
     * @return mixed
     */
    public function viewAny(Admin $user)
    {
        return false;
    }

    /**
     * Determine whether the user can view the senario.
     *
     * @param  \App\Models\Admin  $user
     * @param  \App\Senario  $senario
     * @return mixed
     */
    public function view(Admin $user, Senario $senario)
    {
        return $user->id == $senario->bot->admin_id;
    }

    /**
     * Determine whether the user can create senarios.
     *
     * @param  \App\Models\Admin  $user
     * @return mixed
     */
    public function create(Admin $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the senario.
     *
     * @param  \App\Models\Admin  $user
     * @param  \App\Senario  $senario
     * @return mixed
     */
    public function update(Admin $user, Senario $senario)
    {
        return $user->id == $senario->bot->admin_id;
    }

    /**
     * Determine whether the user can delete the senario.
     *
     * @param  \App\Models\Admin  $user
     * @param  \App\Senario  $senario
     * @return mixed
     */
    public function delete(Admin $user, Senario $senario)
    {
        return $user->id == $senario->bot->admin_id;
    }

    /**
     * Determine whether the user can restore the senario.
     *
     * @param  \App\Models\Admin  $user
     * @param  \App\Senario  $senario
     * @return mixed
     */
    public function restore(Admin $user, Senario $senario)
    {
        return $user->id == $senario->bot->admin_id;
    }

    /**
     * Determine whether the user can permanently delete the senario.
     *
     * @param  \App\Models\Admin  $user
     * @param  \App\Senario  $senario
     * @return mixed
     */
    public function forceDelete(Admin $user, Senario $senario)
    {
        return $user->id == $senario->bot->admin_id;
    }
}
