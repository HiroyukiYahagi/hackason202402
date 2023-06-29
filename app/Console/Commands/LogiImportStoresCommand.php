<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\LogizardService;

use App\Models\Stores;
use Carbon\Carbon;

class LogiImportStoresCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'logi:import_stores {--from=} {--to=}';

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
        $from = $this->option("from");
        $to = $this->option("to");
        if( $from == null ){
            $from = Carbon::now()->subDay(30);
        }else{
            $from = Carbon::parse($from);
        }
        if( $to == null ){
            $to = Carbon::now()->subDay(1);
        }else{
            $to = Carbon::parse($to);
        }

        while ( $from < $to ) {

            foreach( config("services.logizard.area") as $area => $key ){
                $result = $this->logizardService->getData($area, "/common/export/export", "EXPORT_DATA", [
                    "FILE_ID" => 1,
                    "PTRN_ID" => -1,
                    "TARGET_DATE_FROM" => $from->format("Ymd"),
                    "TARGET_DATE_TO" => $from->copy()->addDay(30)->format("Ymd")
                ]);
                // var_dump($from->format("Ymd"));
                // var_dump($from->copy()->addDay(30)->format("Ymd"));
                $from = $from->addDay(30);

                if(isset($result["ERROR_CODE"])){
                    var_dump($result);
                    continue;
                }

                foreach( $result as $re ){
                    Stores::createFromApi( $re );
                }
            }
        }
    }
}
