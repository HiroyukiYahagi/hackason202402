<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use \Auth;
use App\Services\AccountService;
use App\Services\SenarioService;
use App\Models\Account;
use App\Models\Bot;

class AccountController extends Controller
{
    protected $accountService;

    public function __construct(AccountService $accountService){
        $this->middleware('auth:admin');
        $this->accountService = $accountService;
    }

    public function index(Request $request, Bot $bot){
        $param = $request->all();
        $acconts = $this->accountService->paginate($param);
        return view("admin.accounts.index", [
            "bot" => $bot, "accounts" => $acconts, "param" => $param
        ]);
    }

    public function view(Request $request, Bot $bot, Account $account){
        $account->load(["properties.label", "senario", "bot"]);
        return view("admin.accounts.view", [
            "bot" => $bot, "account" => $account
        ]);
    }

    public function edit(Request $request, Bot $bot, Account $account){
        $account = $this->accountService->edit($account->id, $request->all());
        return back()->with("message", "更新しました");
    }

    public function property(Request $request, Bot $bot, Account $account){
        $account->load(["properties.label", "senario", "bot"]);
        $account->property_table = $request->input("property");
        return back()->with("message", "更新しました");
    }

    public function send(Request $request, Bot $bot, Account $account){
        $correctBody = "\$json =<<<EOF\n{ \"messages\": ".$request->input("messages")."}\nEOF;\nreturn \$json;";
        $msg = eval($correctBody);
        $account->sendJsonMessage($msg);
        return back()->with("message", "更新しました");
    }

    public function delete(Request $request, Bot $bot, Account $account){
        $this->accountService->delete($account->id);
        return redirect()->route("admin.accounts.index", [
            "bot" => $bot
        ])->with("message", "削除しました");
    }
}
