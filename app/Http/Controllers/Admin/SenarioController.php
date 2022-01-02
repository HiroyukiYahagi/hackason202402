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
    }

    public function delete(Request $request, Bot $bot, Senario $senario){
    }
}
