<?php

namespace App\Http\Controllers\Api\Rest;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Services\LogizardService;
use App\Services\RelationService;

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
}
