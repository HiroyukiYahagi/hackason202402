<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\LogizardService;

class TestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'do:test';

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
    public function __construct(LogizardService $logizardService)
    {
        parent::__construct();
        $this->logizardService = $logizardService;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $result = $this->logizardService->getData("miraku", "/common/export/export", "EXPORT_DATA", [
            "FILE_ID" => 1,
            "PTRN_ID" => -1,
            "TARGET_DATE_FROM" => "20221201",
            "TARGET_DATE_TO" => "20221231"
        ]);
        var_dump($result);
    }
}
