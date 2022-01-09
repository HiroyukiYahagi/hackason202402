<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use \Auth;
use App\Services\BotService;
use App\Models\Bot;

class BotController extends Controller
{
    protected $botService;

    public function __construct(BotService $botService){
        $this->middleware('auth:admin');
        $this->botService = $botService;
    }

    public function index(Request $request){
        return redirect()->route("admin.bots.view", [
            "bot" => $request->input("bot_id")
        ]);
    }

    public function add(Request $request){
        $admin = Auth::guard("admin")->user();
        $this->botService->add($admin->id);
        return back()->with("message", "新しいBOTを作成しました");
    }

    public function view(Request $request, Bot $bot){
        $admin = Auth::guard("admin")->user();
        return view("admin.bots.view", [
            "bot" => $bot
        ]);
    }

    public function showEdit(Request $request, Bot $bot){
        $admin = Auth::guard("admin")->user();
        return view("admin.bots.edit", [
            "bot" => $bot
        ]);
    }

    public function edit(Request $request, Bot $bot){
        $admin = Auth::guard("admin")->user();
        $bot = $this->botService->edit( $bot->id, $request->all() );
        return redirect()->route("admin.bots.edit", [
            "bot" => $bot
        ])->with("message", "更新しました。");
    }

    public function recalc(Request $request, Bot $bot){
        $bot = $this->botService->recalc( $bot->id );
        return redirect()->route("admin.senarios.index", [
            "bot" => $bot
        ])->with("message", "シナリオ配分を再計算しました");
    }

    public function delete(Request $request, Bot $bot){
        $admin = Auth::guard("admin")->user();
        $bot = $this->botService->delete( $bot->id );
        return redirect()->route("admin.index")->with("message", "ボットを削除しました");
    }

    public function setRichMenu(Request $request, Bot $bot){
        $bot = $this->botService->setRichMenu( $bot->id, $request->all());
        return back()->with("message", "新しいBOTを作成しました");   
    }
}
