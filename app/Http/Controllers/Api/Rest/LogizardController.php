<?php

namespace App\Http\Controllers\Api\Rest;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Services\LogizardService;

class LogizardController extends Controller
{

    protected $logizardService;

    public function __construct(LogizardService $logizardService){
        $this->logizardService = $logizardService;
    }

    function view(Request $request){
        $result = $this->logizardService->getData( $request->input("area"), $request->input("path"), $request->input("level"), $request->except(["area", "path", "level"]) );
        return response()->json($result);
    }
}
