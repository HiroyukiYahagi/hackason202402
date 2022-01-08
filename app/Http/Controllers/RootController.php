<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Account;

class RootController extends Controller
{

    public function __construct(){
    }

    public function index(){
        return view("index");
    }

    public function account(Request $request, $hash){
        $account = Account::where("hash", $hash)->firstOrFail();
        return view("account", [
            "account" => $account
        ]);
    }

    public function editAccount(Request $request, $hash){
        $account = Account::where("hash", $hash)->firstOrFail();
        $account->property_table = $request->input("property");
        return back()->with("message", "情報を更新しました");
    }
}

