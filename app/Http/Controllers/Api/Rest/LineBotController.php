<?php

namespace App\Http\Controllers\Api\Rest;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Services\LineBotService;
use App\Models\Bot;

class LineBotController extends Controller
{
    protected $lineBotService;

    public function __construct(LineBotService $lineBotService){
        $this->lineBotService = $lineBotService;
    }

    public function webhook (Request $request, $hash)
    {
        $bot = Bot::where("hash", $hash)->first();
        if( $bot == null ){
            return abort(404);
        }
        $result = $this->lineBotService->executeRequest($bot, $request->all());
        return response()->json([
            "result" =>$result
        ]);
    }
}

