<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\Account;
use Illuminate\Auth\Access\HandlesAuthorization;

class AccountPolicy
{
    use HandlesAuthorization;
    
    /**
     * Determine whether the user can view any accounts.
     *
     * @param  \App\Models\Admin  $user
     * @return mixed
     */
    public function viewAny(Admin $user)
    {
        return false;
    }

    /**
     * Determine whether the user can view the account.
     *
     * @param  \App\Models\Admin  $user
     * @param  \App\Account  $account
     * @return mixed
     */
    public function view(Admin $user, Account $account)
    {
        return $user->id == $account->bot->admin_id;
    }

    /**
     * Determine whether the user can create accounts.
     *
     * @param  \App\Models\Admin  $user
     * @return mixed
     */
    public function create(Admin $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the account.
     *
     * @param  \App\Models\Admin  $user
     * @param  \App\Account  $account
     * @return mixed
     */
    public function update(Admin $user, Account $account)
    {
        return $user->id == $account->bot->admin_id;
    }

    /**
     * Determine whether the user can delete the account.
     *
     * @param  \App\Models\Admin  $user
     * @param  \App\Account  $account
     * @return mixed
     */
    public function delete(Admin $user, Account $account)
    {
        return $user->id == $account->bot->admin_id;
    }

    /**
     * Determine whether the user can restore the account.
     *
     * @param  \App\Models\Admin  $user
     * @param  \App\Account  $account
     * @return mixed
     */
    public function restore(Admin $user, Account $account)
    {
        return $user->id == $account->bot->admin_id;
    }

    /**
     * Determine whether the user can permanently delete the account.
     *
     * @param  \App\Models\Admin  $user
     * @param  \App\Account  $account
     * @return mixed
     */
    public function forceDelete(Admin $user, Account $account)
    {
        return $user->id == $account->bot->admin_id;
    }
}
