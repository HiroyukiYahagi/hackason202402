<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use \Auth;
use App\Services\BotService;

class BotController extends Controller
{
    protected $botService;

    public function __construct(BotService $botService){
        $this->middleware('auth:admin');
        $this->botService = $botService;
    }

    public function add(Request $request){
        $admin = Auth::guard("admin")->user();
        $this->botService->add($admin->id);
        return back()->with("message", "新しいBOTを作成しました");
    }
}
