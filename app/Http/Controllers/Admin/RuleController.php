<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use \Auth;
use App\Services\RuleService;
use App\Models\Rule;
use App\Models\Senario;
use App\Models\Bot;

class RuleController extends Controller
{
    protected $ruleService;

    public function __construct(RuleService $ruleService){
        $this->middleware('auth:admin');
        $this->ruleService = $ruleService;
    }

    public function index(Request $request, Bot $bot, Senario $senario){
        return view("admin.rules.index", [
            "bot" => $bot, "senario" => $senario
        ]);
    }

    public function add(Request $request, Bot $bot, Senario $senario){
        $this->ruleService->add($senario->id);
        return redirect()->route("admin.rules.index", [
            "bot" => $bot, "senario" => $senario
        ])->with("message", "ルールを作成しました");
    }

    public function view(Request $request, Bot $bot, Senario $senario, Rule $rule){
        return view("admin.rules.view", [
            "bot" => $bot, "senario" => $senario, "rule" => $rule
        ]);
    }

    public function edit(Request $request, Bot $bot, Senario $senario, Rule $rule){
        $rule = $this->ruleService->edit( $rule->id, $request->all() );
        return back()->with("ルールを変更しました");
    }

    public function delete(Request $request, Bot $bot, Senario $senario, Rule $rule){

        $this->ruleService->delete( $rule->id );
        return redirect()->route("admin.rules.index", [
            "bot" => $bot, "senario" => $senario
        ])->with("message", "ルールを作成しました");
    }

}
