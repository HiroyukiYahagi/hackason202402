<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\AdResult\FacebookAdResultService;

use App\Models\Bot;
use App\Models\Rule;
use App\Models\Message;
use App\Models\Account;
use App\Services\LineBotService;

class TestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:do';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    protected $lineBotService;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(LineBotService $lineBotService)
    {
        parent::__construct();

        $this->lineBotService = $lineBotService;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // Api::init( config("services.ads.facebook.app_id"), config("services.ads.facebook.secret"), config("services.ads.facebook.access_token"));

        // $account = new AdAccount( config("services.ads.facebook.account_id") );
        // $cursor = $account->getCampaigns();
        // var_dump($cursor);

        $bot = Bot::first();
        var_dump($bot->toArray());

        $this->lineBotService->getAudienceGroups($bot);


        // $account = Account::first();
        // $rules = Rule::get();
        // $message = Message::first();

        // var_dump($rules);

        // $rules->each( function($rule) use ($account, $message) {
        //     var_dump( $rule->id );
        //     $result = $rule->isApplicable( $account, $message );
        //     var_dump( "result:".$result );
        // }); 

    }
}
