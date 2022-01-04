<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use \Auth;
use App\Services\SenarioService;
use App\Models\Senario;
use App\Models\Bot;

class SenarioController extends Controller
{
    protected $senarioService;

    public function __construct(SenarioService $senarioService){
        $this->middleware('auth:admin');
        $this->senarioService = $senarioService;
    }

    public function index(Request $request, Bot $bot){
        if( $request->input("senario_id") ){
            return redirect()->route("admin.senarios.view", [
                "bot" => $bot, "senario" => $request->input("senario_id")
            ]);
        }
        return view("admin.senarios.index", [
            "bot" => $bot
        ]);
    }

    public function add(Request $request, Bot $bot){
        $this->senarioService->add($bot->id);
        return redirect()->route("admin.senarios.index", [
            "bot" => $bot
        ])->with("message", "シナリオを作成しました");
    }

    public function view(Request $request, Bot $bot, Senario $senario){
        return view("admin.senarios.view", [
            "bot" => $bot, "senario" => $senario
        ]);
    }

    public function edit(Request $request, Bot $bot, Senario $senario){

        $senario = $this->senarioService->edit($senario->id, $request->all());

        return back()->with("message", "シナリオ設定を変更しました");
    }

    public function delete(Request $request, Bot $bot, Senario $senario){

        $this->senarioService->delete($senario->id);

        return redirect()->route("admin.senarios.index", [
            "bot" => $bot
        ])->with("message", "シナリオを削除しました");
    }

    public function accounts(Request $request, Bot $bot, Senario $senario){
        return view("admin.senarios.accounts", [
            "bot" => $bot, "senario" => $senario
        ]);
    }
}
