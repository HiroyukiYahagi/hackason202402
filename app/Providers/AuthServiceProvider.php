<?php

namespace App\Providers;

use App\Models\Admin;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Models\Bot' => 'App\Policies\BotPolicy',
        'App\Models\Senario' => 'App\Policies\SenarioPolicy',
        'App\Models\Rule' => 'App\Policies\RulePolicy',
        'App\Models\Action' => 'App\Policies\ActionPolicy',
        'App\Models\Account' => 'App\Policies\AccountPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
    }
}
