<?php

namespace App\Http\Controllers\Api\Rest;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Services\LogizardService;
use App\Services\RelationService;
use App\Models\Ranking;

class OutboundController extends Controller
{

    protected $logizardService;
    protected $relationService;

    public function __construct(LogizardService $logizardService, RelationService $relationService){
        $this->logizardService = $logizardService;
        $this->relationService = $relationService;
    }

    function logizard(Request $request){
        $result = $this->logizardService->getData( $request->input("area"), $request->input("path"), $request->input("level"), $request->except(["area", "path", "level"]) );
        return response()->json($result);
    }

    function relation(Request $request){
        $result = $this->relationService->getData( $request->input("path"), $request->input("method"), $request->all() );
        return response()->json($result);
    }

    function rankings(Request $request){
        $rank = Ranking::where("name", $request->input("name"))->first();

        $cnt = isset($rank) ? $rank->registered_cnt : 0;

        $ranking = Ranking::where("registered_cnt", ">", $cnt)->count() + 1;

        $next = Ranking::where("registered_cnt", ">", $cnt)->orderBy("registered_cnt", "ASC")->first();
        $previous = Ranking::where("registered_cnt", "<=", $cnt)->where("id", "<>", optional($rank)->id)->orderBy("registered_cnt", "DESC")->first();

        $max = Ranking::sum("registered_cnt");

        $cnt ++;
        $max ++;

        return response()->json([
            "name" => $request->input("name"),
            "registered_cnt" => floor($cnt / $max * 7000000),
            "ranking" => $ranking,
            "next" => $next,
            "previous" => $previous,
        ]);
    }
}
