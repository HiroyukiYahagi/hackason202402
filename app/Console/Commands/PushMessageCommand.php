<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\Rule;
use App\Models\Account;
use Carbon\Carbon;

class PushMessageCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:push {--date=}';

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

        if( $this->option("date") ){
            Carbon::setTestNow($this->option("date"));
            $this->info("set date: ".now());
        }
        
        Rule::with(["actions", "senario"])->where("is_valid", 1)->where("rule_type", Rule::HOURLY)->get()->each( function($rule){
            $this->info( "rule id: ".$rule->id);
            if($rule->senario == null){
                return;
            }
            $rule->senario->accounts()->whereNull("blocked_at")->chunk(100, function($accounts) use ($rule){
                $accounts->each(function($account) use ($rule){
                    $this->info( "account id: ".$account->id);
                    if( $rule->isApplicable( $account ) ){
                        $rule->doActions( $account );
                        $rule->increment("applied_count");
                    }
                });
            });
        });
        $this->info("end push message");
    }
}
