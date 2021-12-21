<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\Rule;
use Illuminate\Auth\Access\HandlesAuthorization;

class RulePolicy
{
    use HandlesAuthorization;
    
    /**
     * Determine whether the user can view any rules.
     *
     * @param  \App\Models\Admin  $user
     * @return mixed
     */
    public function viewAny(Admin $user)
    {
        return false;
    }

    /**
     * Determine whether the user can view the rule.
     *
     * @param  \App\Models\Admin  $user
     * @param  \App\Rule  $rule
     * @return mixed
     */
    public function view(Admin $user, Rule $rule)
    {
        return $user->id == $rule->senario->bot->admin_id;
    }

    /**
     * Determine whether the user can create rules.
     *
     * @param  \App\Models\Admin  $user
     * @return mixed
     */
    public function create(Admin $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the rule.
     *
     * @param  \App\Models\Admin  $user
     * @param  \App\Rule  $rule
     * @return mixed
     */
    public function update(Admin $user, Rule $rule)
    {
        return $user->id == $rule->senario->bot->admin_id;
    }

    /**
     * Determine whether the user can delete the rule.
     *
     * @param  \App\Models\Admin  $user
     * @param  \App\Rule  $rule
     * @return mixed
     */
    public function delete(Admin $user, Rule $rule)
    {
        return $user->id == $rule->senario->bot->admin_id;
    }

    /**
     * Determine whether the user can restore the rule.
     *
     * @param  \App\Models\Admin  $user
     * @param  \App\Rule  $rule
     * @return mixed
     */
    public function restore(Admin $user, Rule $rule)
    {
        return $user->id == $rule->senario->bot->admin_id;
    }

    /**
     * Determine whether the user can permanently delete the rule.
     *
     * @param  \App\Models\Admin  $user
     * @param  \App\Rule  $rule
     * @return mixed
     */
    public function forceDelete(Admin $user, Rule $rule)
    {
        return $user->id == $rule->senario->bot->admin_id;
    }
}
