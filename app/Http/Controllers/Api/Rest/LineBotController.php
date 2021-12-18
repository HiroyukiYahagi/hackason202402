<?php

namespace App\Http\Controllers\Api\Rest;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Services\LineBotService;

class LineBotController extends Controller
{
    protected $lineBotService;

    public function __construct(LineBotService $lineBotService){
        $this->lineBotService = $lineBotService;
    }

    public function webhook (Request $request)
    {
        $result = $this->lineBotService->executeRequest($request);
        return response('OK', 200);
    }
}

