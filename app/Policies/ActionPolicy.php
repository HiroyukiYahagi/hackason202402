<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\Action;
use Illuminate\Auth\Access\HandlesAuthorization;

class ActionPolicy
{
    use HandlesAuthorization;
    
    /**
     * Determine whether the user can view any actions.
     *
     * @param  \App\Models\Admin  $user
     * @return mixed
     */
    public function viewAny(Admin $user)
    {
        return false;
    }

    /**
     * Determine whether the user can view the action.
     *
     * @param  \App\Models\Admin  $user
     * @param  \App\Action  $action
     * @return mixed
     */
    public function view(Admin $user, Action $action)
    {
        return $user->id == $action->rule->senario->bot->admin_id;
    }

    /**
     * Determine whether the user can create actions.
     *
     * @param  \App\Models\Admin  $user
     * @return mixed
     */
    public function create(Admin $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the action.
     *
     * @param  \App\Models\Admin  $user
     * @param  \App\Action  $action
     * @return mixed
     */
    public function update(Admin $user, Action $action)
    {
        return $user->id == $action->rule->senario->bot->admin_id;
    }

    /**
     * Determine whether the user can delete the action.
     *
     * @param  \App\Models\Admin  $user
     * @param  \App\Action  $action
     * @return mixed
     */
    public function delete(Admin $user, Action $action)
    {
        return $user->id == $action->rule->senario->bot->admin_id;
    }

    /**
     * Determine whether the user can restore the action.
     *
     * @param  \App\Models\Admin  $user
     * @param  \App\Action  $action
     * @return mixed
     */
    public function restore(Admin $user, Action $action)
    {
        return $user->id == $action->rule->senario->bot->admin_id;
    }

    /**
     * Determine whether the user can permanently delete the action.
     *
     * @param  \App\Models\Admin  $user
     * @param  \App\Action  $action
     * @return mixed
     */
    public function forceDelete(Admin $user, Action $action)
    {
        return $user->id == $action->rule->senario->bot->admin_id;
    }
}
