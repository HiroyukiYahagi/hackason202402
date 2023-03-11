<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\AdResult\FacebookAdResultService;

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

    protected $facebookAdResultService;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(FacebookAdResultService $facebookAdResultService)
    {
        parent::__construct();

        $this->facebookAdResultService = $facebookAdResultService;
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

        $this->facebookAdResultService->sync(now()->subDay(7), now()->subDay(1));
    }
}
