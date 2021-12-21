<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\Bot;
use Illuminate\Auth\Access\HandlesAuthorization;

class BotPolicy
{
    use HandlesAuthorization;
    
    /**
     * Determine whether the user can view any bots.
     *
     * @param  \App\Models\Admin  $user
     * @return mixed
     */
    public function viewAny(Admin $user)
    {
        return false;
    }

    /**
     * Determine whether the user can view the bot.
     *
     * @param  \App\Models\Admin  $user
     * @param  \App\Bot  $bot
     * @return mixed
     */
    public function view(Admin $user, Bot $bot)
    {
        return $user->id == $bot->admin_id;
    }

    /**
     * Determine whether the user can create bots.
     *
     * @param  \App\Models\Admin  $user
     * @return mixed
     */
    public function create(Admin $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the bot.
     *
     * @param  \App\Models\Admin  $user
     * @param  \App\Bot  $bot
     * @return mixed
     */
    public function update(Admin $user, Bot $bot)
    {
        return $user->id == $bot->admin_id;
    }

    /**
     * Determine whether the user can delete the bot.
     *
     * @param  \App\Models\Admin  $user
     * @param  \App\Bot  $bot
     * @return mixed
     */
    public function delete(Admin $user, Bot $bot)
    {
        return $user->id == $bot->admin_id;
    }

    /**
     * Determine whether the user can restore the bot.
     *
     * @param  \App\Models\Admin  $user
     * @param  \App\Bot  $bot
     * @return mixed
     */
    public function restore(Admin $user, Bot $bot)
    {
        return $user->id == $bot->admin_id;
    }

    /**
     * Determine whether the user can permanently delete the bot.
     *
     * @param  \App\Models\Admin  $user
     * @param  \App\Bot  $bot
     * @return mixed
     */
    public function forceDelete(Admin $user, Bot $bot)
    {
        return $user->id == $bot->admin_id;
    }
}
