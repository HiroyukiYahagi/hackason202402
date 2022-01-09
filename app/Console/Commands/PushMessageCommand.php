<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\Rule;
use App\Models\Account;

class PushMessageCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:push';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info("start push message");
        
        Rule::with(["actions"])->where("is_valid", 1)->where("rule_type", Rule::HOURLY)->get()->each( function($rule){
           $rule->senario->accounts()->whereNull("blocked_at")->chunk(100, function($accounts) use ($rule){
                $accounts->each(function($account) use ($rule){
                    if( $rule->isApplicable( $account ) ){
                        $rule->doActions( $account );
                    }
                });
            });
        });
        $this->info("end push message");
    }
}
